<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;

class GeminiAiService
{
    private $geminiApiKey;
    private $geminiEndpoint;
   

    public function __construct()
    {
        $this->geminiApiKey = env('GEMINI_API_KEY');
        $this->geminiEndpoint = env('GEMINI_BASE_URL');
    }

    public function analyzeImages(array $imagePaths)
    {
        $client = new Client();

        $imagesData = [];
        foreach ($imagePaths as $imagePath) {
            
            if (!file_exists(($imagePath))) {
                throw new \Exception("File not found: $imagePath");
            }

            $mimeType = File::mimeType($imagePath);
            $imageData = base64_encode(File::get($imagePath));

            $imagesData[] = [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $imageData,
                ],
            ];
        }

        $requestContent = [
            'contents' => [
                [
                    'parts' => [
                        ...$imagesData,
                        [
                            'text' => 'Analyze these performance graphs images and provide a summary of the sites performance.',
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $client->request('POST', $this->geminiEndpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'key' => $this->geminiApiKey,
                ],
                'json' => $requestContent,
            ]);

            $responseBody = json_decode($response->getBody(), true);
            return $responseBody;
        } catch (ClientException $e) {
            throw $e;
        }
    }
}