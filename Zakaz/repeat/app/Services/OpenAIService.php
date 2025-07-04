<?php
namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use OpenAI;

class OpenAIService
{
    private $client;
    private const MAX_IMAGE_SIZE       = 20 * 1024 * 1024; // 20MB
    private const SUPPORTED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public function __construct()
    {
        $this->client = OpenAI::client(config('openai.key'));
    }

    public function summarizeAttemptResultsWithAI(array $evaluatedAnswers, string $examType = 'speaking'): array
    {
        try {
            $prompt = $examType === 'writing'
            ? $this->getWritingSummaryPrompt()
            : $this->getSpeakingSummaryPrompt();

            $response = $this->client->chat()->create([
                'model'       => config('openai.model', 'gpt-4o'),
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => $prompt,
                    ],
                    [
                        'role'    => 'user',
                        'content' => [
                            [
                                'type' => 'text',
                                'text' => "Here is the list of evaluated answers:\n\n" . json_encode($evaluatedAnswers, JSON_PRETTY_PRINT),
                            ],
                        ],
                    ],
                ],
                'max_tokens'  => 1000,
                'temperature' => 0.3,
            ]);

            $result = json_decode($response['choices'][0]['message']['content'], true);

            return $result ?? $this->getErrorResponse();
        } catch (Exception $e) {
            Log::error('OpenAI Summary Error: ' . $e->getMessage());
            return $this->getErrorResponse();
        }
    }

    private function getWritingSummaryPrompt(): string
    {
        return <<<PROMPT
You are an AI writing exam summarizer.

You are given multiple writing exam evaluations, each with a score, a breakdown (content_ideas, organization_structure, language_grammar, mechanics_style), and feedback (strengths, improvements, overall comment).

Your task is to:
1. Compute total and average score.
2. Average each breakdown metric.
3. Merge feedbacks to:
   - Find common strengths
   - Find common improvement areas
   - Give an overall summary

Use this output format:

```json
{
  "status": "summary",
  "score": 240,
  "avg_score": 80,
  "breakdown": {
    "content_ideas": 20,
    "organization_structure": 21,
    "language_grammar": 19,
    "mechanics_style": 20
  },
  "feedback": {
    "strengths": ["Good idea development", "Strong vocabulary"],
    "improvements": ["Weak transitions", "Minor grammar mistakes"],
    "overall": "The writing responses show solid structure and vocabulary usage, with room for improvement in coherence and mechanics."
  }
}
Only return valid JSON. Do not include any extra explanations.
PROMPT;
    }

    private function getSpeakingSummaryPrompt(): string
    {
        return <<<PROMPT
You are an AI speaking exam summarizer.

You are given multiple speaking exam evaluations. Each evaluation contains a score, a breakdown (content_relevance, language_accuracy, fluency_coherence, depth_detail), and feedback (strengths, improvements, overall comment).

Your task is to:
1. Compute total and average score.
2. Average each breakdown metric.
3. Identify common strengths and improvements.
4. Provide a final recommendation summarizing the user's speaking ability.

Use this output format:

```json
{
  "status": "summary",
  "score": 255,
  "avg_score": 85,
  "breakdown": {
    "content_relevance": 22,
    "language_accuracy": 21,
    "fluency_coherence": 21,
    "depth_detail": 21
  },
  "feedback": {
    "strengths": ["Fluent speaking", "Good vocabulary", "Clear ideas"],
    "improvements": ["Improve coherence", "More detailed responses"],
    "overall": "The user speaks fluently with a clear understanding of topics, but can enhance coherence and depth in answers."
  }
}
Only return valid JSON. Do not include any extra explanations.
PROMPT;
    }

    /**
     * Evaluate speaking exam response
     */
    public function evaluateSpeakingExam(string $question, string $userResponse, $imagePaths = null, $argumentList = null): array
    {
        try {
            $prompt   = $this->buildSpeakingPrompt($question, $userResponse, $argumentList);
            $messages = $this->buildMessages($prompt, $imagePaths, 'speaking');

            $response = $this->client->chat()->create([
                'model'       => config('openai.model', 'gpt-4o'),
                'messages'    => $messages,
                'max_tokens'  => 1000,
                'temperature' => 0.3,
            ]);

            $content = $response['choices'][0]['message']['content'];
            $result  = json_decode($content, true);

            if (! $this->validateResponse($result, 'speaking')) {
                throw new Exception('Invalid response format from OpenAI');
            }

            return $result;

        } catch (Exception $e) {
            Log::error('OpenAI Speaking Exam Error: ' . $e->getMessage(), [
                'question'        => $question,
                'response_length' => strlen($userResponse),
                'has_images'      => ! empty($imagePaths),
                'has_arguments'   => ! empty($argumentList),
            ]);
            return $this->getErrorResponse();
        }
    }

    /**
     * Evaluate writing exam response
     */
    public function evaluateWritingExam(string $question, ?string $userText = null, $imagePaths = null): array
    {
        try {
            if (empty($userText)) {
                return [
                    'status'  => 'error',
                    'message' => 'No text content provided for evaluation.',
                    'score'   => null,
                ];
            }

            $prompt   = $this->buildWritingPrompt($question, $userText);
            $messages = $this->buildMessages($prompt, $imagePaths, 'writing');

            $response = $this->client->chat()->create([
                'model'       => config('openai.model', 'gpt-4o'),
                'messages'    => $messages,
                'max_tokens'  => 1200,
                'temperature' => 0.3,
            ]);

            $content = $response['choices'][0]['message']['content'];
            $result  = json_decode($content, true);

            // Validate response format
            if (! $this->validateResponse($result, 'writing')) {
                throw new Exception('Invalid response format from OpenAI');
            }

            return $result;

        } catch (Exception $e) {
            Log::error('OpenAI Writing Exam Error: ' . $e->getMessage(), [
                'question'    => $question,
                'text_length' => strlen($userText ?? ''),
                'has_images'  => ! empty($imagePaths),
            ]);
            return $this->getErrorResponse();
        }
    }

    /**
     * Build the speaking evaluation prompt
     */
    private function buildSpeakingPrompt(string $question, string $userResponse, $argumentList = null): string
    {
        $prompt = "Question: {$question}\nUser Response: {$userResponse}";

        if ($argumentList) {
            $arguments = is_array($argumentList) ? implode(', ', $argumentList) : $argumentList;
            $prompt .= "\nArgument List: {$arguments}";
        }

        return $prompt;
    }

    /**
     * Build the writing evaluation prompt
     */
    private function buildWritingPrompt(string $question, ?string $userText = null): string
    {
        return "Question: {$question}\nUser's Written Response: {$userText}";
    }

    /**
     * Build messages array for OpenAI API
     */
    private function buildMessages(string $prompt, $imagePaths = null, string $examType = 'speaking'): array
    {
        $systemPrompt = $examType === 'speaking' ? $this->getSpeakingSystemPrompt() : $this->getWritingSystemPrompt();

        $messages = [
            [
                'role'    => 'system',
                'content' => $systemPrompt,
            ],
        ];

        $userMessage = [
            'role'    => 'user',
            'content' => [],
        ];

        $userMessage['content'][] = [
            'type' => 'text',
            'text' => $prompt,
        ];

        if ($imagePaths) {
            $imagePathsArray = is_array($imagePaths) ? $imagePaths : [$imagePaths];

            foreach ($imagePathsArray as $imagePath) {
                if ($this->validateImagePath($imagePath)) {
                    try {
                        $imageData                = $this->processImage($imagePath);
                        $userMessage['content'][] = [
                            'type'      => 'image_url',
                            'image_url' => [
                                'url'    => $imageData,
                                'detail' => 'high',
                            ],
                        ];
                    } catch (Exception $e) {
                        Log::warning('Failed to process image: ' . $e->getMessage(), [
                            'image_path' => $imagePath,
                        ]);
                    }
                }
            }
        }

        $messages[] = $userMessage;
        return $messages;
    }

    /**
     * Validate image path and file
     */
    private function validateImagePath(string $imagePath): bool
    {
        if (! $imagePath || ! file_exists($imagePath)) {
            return false;
        }

        // Check file size
        if (filesize($imagePath) > self::MAX_IMAGE_SIZE) {
            Log::warning('Image file too large', ['path' => $imagePath, 'size' => filesize($imagePath)]);
            return false;
        }

        // Check MIME type
        $mimeType = mime_content_type($imagePath);
        if (! in_array($mimeType, self::SUPPORTED_MIME_TYPES)) {
            Log::warning('Unsupported image format', ['path' => $imagePath, 'mime' => $mimeType]);
            return false;
        }

        return true;
    }

    /**
     * Process and encode image
     */
    private function processImage(string $imagePath): string
    {
        $imageData = file_get_contents($imagePath);
        $mimeType  = mime_content_type($imagePath);

        // Additional validation
        if (! $imageData) {
            throw new Exception('Failed to read image file');
        }

        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }

    /**
     * Get system prompt for speaking evaluation
     */
    private function getSpeakingSystemPrompt(): string
    {
        return 'You are an AI evaluator for a speaking exam system. Your role is to assess spoken responses that have been converted to text via speech-to-text technology.

## Your Tasks:

### 1. Topic Deviation Detection (Priority #1)
First, analyze if the response stays on topic:
- Check if the user\'s answer directly addresses the given question
- Verify the response relates to the main subject/theme
- Detect if the user went off-topic, gave irrelevant information, or didn\'t attempt to answer

### 2. Speaking Assessment (Only if on-topic)
If the response is on-topic, evaluate based on these criteria:
- **Content Relevance (25 points)**: How well does the answer address the question?
- **Language Accuracy (25 points)**: Grammar, vocabulary usage, and sentence structure
- **Fluency & Coherence (25 points)**: Flow of ideas, logical organization, transitions
- **Depth & Detail (25 points)**: Completeness of response, examples, elaboration

### 3. Argument List Evaluation (if provided)
If an argument list is provided alongside the question:
- Assess how well the response incorporates or addresses the provided arguments
- Evaluate the logical connection between the arguments and the user\'s response
- Consider if the response demonstrates understanding of the argument context
- Factor argument relevance into the Content Relevance scoring

## Response Format:

### For Topic Deviation:
```json
{
  "status": "deviation",
  "message": "The response does not address the given question. The user talked about [brief description] instead of [expected topic].",
  "score": null
}
```

### For Valid On-Topic Responses:
```json
{
  "status": "evaluated",
  "score": 85,
  "breakdown": {
    "content_relevance": 22,
    "language_accuracy": 20,
    "fluency_coherence": 21,
    "depth_detail": 22
  },
  "feedback": {
    "strengths": ["Clear understanding of topic", "Good examples provided"],
    "improvements": ["Could expand main argument", "Minor grammar issues"],
    "overall": "Strong response with clear topic understanding."
  }
}
```

## Important Guidelines:
1. Be strict about topic adherence
2. Consider STT limitations for minor transcription errors
3. Be objective and consistent
4. Account for visual context if image(s) provided
5. Provide constructive feedback
6. For multiple images, consider how well the response addresses all visual elements
7. Always return valid JSON format

## Edge Cases:
- **Silent/No Response**: Return deviation status with "No meaningful response detected"
- **Partial Response**: Evaluate on-topic portion, note deviation in feedback

You must respond with valid JSON only. Do not include any text outside the JSON structure.';
    }

    /**
     * Get system prompt for writing evaluation
     */
    private function getWritingSystemPrompt(): string
    {
        return 'You are an AI evaluator for a writing exam system. Your role is to assess written responses and provide detailed feedback.

## Your Task:
Evaluate the written response based on these criteria:
- **Content & Ideas (25 points)**: Relevance to topic, depth of ideas, creativity, critical thinking
- **Organization & Structure (25 points)**: Logical flow, paragraph structure, introduction/conclusion, transitions
- **Language & Grammar (25 points)**: Vocabulary range, sentence variety, grammar accuracy, word choice
- **Mechanics & Style (25 points)**: Spelling, punctuation, formatting, writing style, clarity

## Image Context (if provided):
If one or more images are provided alongside the written response:
- Analyze the content and context of all provided images
- Evaluate how well the written response relates to, describes, or incorporates the image content
- Consider whether the response appropriately addresses visual elements shown in the images
- Assess if the writing demonstrates understanding of the visual context from all images
- For multiple images, evaluate how well the response connects or compares the different visual elements
- Factor image relevance and comprehensiveness into the Content & Ideas scoring

## Response Format:
```json
{
  "status": "evaluated",
  "score": 85,
  "breakdown": {
    "content_ideas": 22,
    "organization_structure": 20,
    "language_grammar": 21,
    "mechanics_style": 22
  },
  "feedback": {
    "strengths": ["Clear thesis statement", "Well-developed arguments", "Good vocabulary usage"],
    "improvements": ["Need better transitions between paragraphs", "Some minor grammar errors", "Conclusion could be stronger"],
    "overall": "Well-written response with strong content and clear organization. Minor improvements needed in transitions and conclusion."
  },
  "word_count": 245,
  "readability": "Appropriate for target level"
}
```

## Important Guidelines:
1. **No topic deviation detection** - Always evaluate the writing as provided
2. Be objective and consistent in scoring
3. Consider the target audience and writing level
4. Provide specific, actionable feedback
5. When image(s) are provided, evaluate how well the writing connects to visual content
6. Evaluate coherence and flow of ideas
7. Consider image-text relationship in content scoring
8. For multiple images, assess how well the response addresses all visual elements
9. Always return valid JSON format

## Scoring Scale:
- **90-100**: Exceptional writing with minimal errors
- **80-89**: Good writing with minor issues
- **70-79**: Adequate writing with some problems
- **60-69**: Below average with significant issues
- **Below 60**: Poor writing requiring major improvement

You must respond with valid JSON only. Do not include any text outside the JSON structure.';
    }

    /**
     * Get error response for API failures
     */
    private function getErrorResponse(): array
    {
        return [
            'status'  => 'error',
            'message' => 'Unable to evaluate response due to technical issues. Please try again.',
            'score'   => null,
        ];
    }

    /**
     * Validate response format for both exam types
     */
    public function validateResponse(array $response, string $examType = 'speaking'): bool
    {
        if (! is_array($response) || empty($response)) {
            return false;
        }

        $requiredKeys = ['status'];

        foreach ($requiredKeys as $key) {
            if (! array_key_exists($key, $response)) {
                return false;
            }
        }

        if ($response['status'] === 'evaluated') {
            $hasRequiredFields = isset($response['score']) &&
            isset($response['breakdown']) &&
            isset($response['feedback']);

            if (! $hasRequiredFields) {
                return false;
            }

            // Validate score range
            if (! is_numeric($response['score']) || $response['score'] < 0 || $response['score'] > 100) {
                return false;
            }

            // Validate breakdown structure
            if (! is_array($response['breakdown']) || empty($response['breakdown'])) {
                return false;
            }

            // Validate feedback structure
            if (! is_array($response['feedback']) || ! isset($response['feedback']['overall'])) {
                return false;
            }

            if ($examType === 'writing') {
                return isset($response['word_count']) && is_numeric($response['word_count']);
            }

            return true;
        }

        if ($response['status'] === 'deviation') {
            return isset($response['message']) && ! empty($response['message']);
        }

        if ($response['status'] === 'error') {
            return isset($response['message']);
        }

        return false;
    }
}
