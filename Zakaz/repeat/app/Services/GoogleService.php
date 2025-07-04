<?php
namespace App\Services;

use Exception;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

class GoogleService
{
    public function ocr($path)
    {
        try {
            $imageAnnotator = new ImageAnnotatorClient();

            $imageContent = file_get_contents($path);

            $image = new Image();
            $image->setContent($imageContent);

            $feature = new Feature();
            $feature->setType(Feature\Type::DOCUMENT_TEXT_DETECTION);

            $response = $imageAnnotator->annotateImage($image, [$feature]);

            $textAnnotations = $response->getFullTextAnnotation();
            $result = '';

            if ($textAnnotations) {
                $result = $textAnnotations->getText();
            } else {
                $result = false;
            }

            $imageAnnotator->close();

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public function speech($path)
    {
        try {
            $speechClient = new SpeechClient();

            $audioContent = file_get_contents($path);

            $config = new RecognitionConfig();
            $config->setEncoding(RecognitionConfig\AudioEncoding::LINEAR16);
            $config->setSampleRateHertz(44100);
            $config->setLanguageCode('en-US');

            $audio = new RecognitionAudio();
            $audio->setContent($audioContent);

            $response = $speechClient->recognize($config, $audio);

            $transcriptions = [];
            foreach ($response->getResults() as $result) {
                foreach ($result->getAlternatives() as $alternative) {
                    $transcriptions[] = $alternative->getTranscript();
                }
            }

            $speechClient->close();

            if (!empty($transcriptions)) {
                $result = implode(' ', $transcriptions);
            } else {
                $result = false;
            }

            return $result;
        } catch (Exception $e) {
            return false;
        }
    }
}