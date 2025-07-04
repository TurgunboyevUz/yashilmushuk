<?php

require __DIR__ . '/vendor/autoload.php';

$client = \ArdaGnsrn\Ollama\Ollama::client();

$imageData = file_get_contents('image.jpg');

if ($imageData === false) {
    die("Error: Could not read image.jpg. Please ensure the file exists and is readable.");
}

$base64ImageData = base64_encode($imageData);

try {
    $completions = $client->completions()->create([
        'model' => 'llama3.2-vision',
        'prompt' => 'What was described in image?',
        'images' => [$base64ImageData]
    ]);

    $response = $completions->response;
    print_r($response);

} catch (GuzzleHttp\Exception\ClientException $e) {
    echo "Ollama API Error: " . $e->getMessage() . "\n";
    echo "Response Body: " . $e->getResponse()->getBody()->getContents() . "\n";
} catch (Exception $e) {
    echo "An unexpected error occurred: " . $e->getMessage() . "\n";
}

?>