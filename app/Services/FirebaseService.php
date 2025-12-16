<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

class FirebaseService
{
    private string $projectId;

    public function __construct()
    {
        $this->projectId = config('services.firebase.project_id');
    }

    private function getAccessToken(): string
    {
        $credentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/firebase.messaging',
            json_decode(file_get_contents(storage_path('app/cred.json')), true),
            dd(json_decode(file_get_contents(storage_path('app/cred.json')), true))

        );

        $token = $credentials->fetchAuthToken();
        return $token['access_token'];
    }

    public function sendToTopic(
        string $topic,
        string $title,
        string $body,
        ?string $image = null
    ) {
        $accessToken = $this->getAccessToken();

        $payload = [
            'message' => [
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                    'image' => $image,
                ],
            ]
        ];

        return Http::withToken($accessToken)
            ->post(
                "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send",
                $payload
            )
            ->json();
    }
}
