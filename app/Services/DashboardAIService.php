<?php

namespace App\Services;

use Google\Cloud\AIPlatform\V1\Client\PredictionServiceClient;

class DashboardAIService
{
    protected $client;

    public function __construct()
    {
        $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');

        if (!$credentialsPath || !file_exists($credentialsPath)) {
            throw new \Exception("Google credentials file not found at $credentialsPath");
        }

        // Read the JSON and pass as array
        $credentials = json_decode(file_get_contents($credentialsPath), true);

        $this->client = new PredictionServiceClient([
            'credentials' => $credentials,
        ]);
    }

    public function analyzeText($modelEndpoint, $text)
    {
        $request = [
            'endpoint' => $modelEndpoint,
            'instances' => [['content' => $text]],
        ];

        $response = $this->client->predict($request);

        return $response->getPredictions();
    }
}
