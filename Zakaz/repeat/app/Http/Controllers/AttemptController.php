<?php
namespace App\Http\Controllers;

use App\Http\Requests\AttemptAnswerRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Exam;
use App\Services\GoogleService;
use App\Services\OpenAIService;
use App\Traits\HttpResponse;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

#[Group('Sinovlar')]
class AttemptController extends Controller
{
    use HttpResponse;

    /**
     * Imtihonni boshlash
     */
    public function start(Request $request)
    {
        $request->validate(['exam_id' => 'required|exists:exams,id']);
        $exam = Exam::find($request->exam_id);

        if (! $request->user()->exams()->where('exam_id', $request->exam_id)->where('status', 'purchased')->exists()) {
            return $this->error('You don\'t have access to this exam', Response::HTTP_FORBIDDEN);
        }

        $request->user()->attempts()->where('status', 0)->update(['status' => 2]);

        $request->user()->attempts()->create([
            'exam_id'     => $exam->id,
            'question_id' => $exam->questions()->first()->id,
        ]);

        return $this->success();
    }

    /**
     * Savolni olish
     */
    public function question(Request $request)
    {
        $attempt = $request->user()->attempts()->where('status', 0)->first();

        if (! $attempt) {
            return $this->error('You don\'t have any active attempt', Response::HTTP_FORBIDDEN);
        }

        return $this->success(new QuestionResource($attempt->question));
    }

    /**
     * Javob berish
     */
    public function answer(AttemptAnswerRequest $request)
    {
        $data    = $request->validated();
        $attempt = $request->user()->attempts()->where('status', 0)->first();

        if (! $attempt) {
            return $this->error('You don\'t have any active attempt', Response::HTTP_FORBIDDEN);
        }

        if ($request->hasFile('image') && $request->hasFile('voice')) {
            return $this->error('You can only upload one input type: image or voice.', Response::HTTP_BAD_REQUEST);
        }

        $google          = new GoogleService;
        $identified_text = $request->answer;

        if ($request->hasFile('image')) {
            $path            = $request->file('image')->store('public/image_answers');
            $identified_text = $google->ocr(storage_path('app/' . $path));
        }

        if ($request->hasFile('voice')) {
            $path            = $request->file('voice')->store('public/voice_answers');
            $identified_text = $google->speech(storage_path('app/' . $path));
        }

        if (! $identified_text) {
            return $this->error('Unable to identify text', Response::HTTP_BAD_REQUEST);
        }

        $openai = new OpenAIService;

        $response = match ($attempt->exam->type) {
            'speaking' => $openai->evaluateSpeakingExam($attempt->question->question, $identified_text, $attempt->question->images, $attempt->question->argument_list),
            'writing' => $openai->evaluateWritingExam($attempt->question->question, $identified_text, $attempt->question->images),
        };

        if ($response['status'] === 'error') {
            return $this->error($response['message'], Response::HTTP_BAD_REQUEST, [
                'status' => $response['status'],
            ]);
        }

        if ($response['status'] == 'devitation') {
            return $this->error($response['message'], Response::HTTP_BAD_REQUEST, [
                'status' => $response['status'],
            ]);
        }

        $attempt->answers()->create([
            'file'      => $path,
            'text'      => $identified_text,

            'status'    => $response['status'],

            'score'     => $response['score'] ?? null,
            'breakdown' => $response['breakdown'] ?? null,
            'feedback'  => $response['feedback'] ?? null,
            'message'   => $response['message'] ?? null,
        ]);

        $attempt->score += $response['score'] ?? 0;
        $attempt->save();

        if ($attempt->exam()->questions()->where('id', ($attempt->exam_question_id + 1))->exists()) {
            $attempt->update([
                'question_id' => $attempt->exam_question_id + 1,
            ]);
        }

        return $this->success([
            'score'     => $response['score'] ?? null,
            'breakdown' => $response['breakdown'] ?? null,
            'feedback'  => $response['feedback'] ?? null,
            'message'   => $response['message'] ?? null,
            'status'    => $response['status'],
        ]);
    }

    /**
     * Imtihonni yakunlash
     */
    public function finish(Request $request)
    {
        $attempt = $request->user()->attempts()->where('status', 0)->first();

        if (! $attempt) {
            return $this->error('You don\'t have any active attempt', Response::HTTP_FORBIDDEN);
        }

        $evaluatedAnswers = $attempt->answers()
            ->where('status', 'evaluated')
            ->get()
            ->map(function ($answer) {
                return [
                    'score'     => (int) $answer->score,
                    'breakdown' => $answer->breakdown,
                    'feedback'  => $answer->feedback,
                ];
            })
            ->toArray();

        $openai = new OpenAIService;
        $response = $openai->summarizeAttemptResultsWithAI($evaluatedAnswers, $attempt->exam->type);

        $attempt->update([
            'score' => $response['avg_score'],
            'result' => $response,
            'status' => 1,
        ]);

        return $this->success([
            'score' => $attempt->score,
            'ai_summary' => $response,
        ]);
    }
}
