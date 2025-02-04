<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class JiraService
{
    private $authHeader;
    private $baseUri;

    public function __construct()
    {
        $email = 'your_email@example.com'; // Замените на ваш Email
        $apiToken = 'your_api_token'; // Замените на ваш API-токен
        $this->baseUri = 'https://your-domain.atlassian.net/rest/api/3/'; // Базовый URL API Jira
        $this->authHeader = "Basic " . base64_encode("$email:$apiToken");
    }

    public function getIssues($projectKey)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authHeader,
            'Accept' => 'application/json',
        ])->get($this->baseUri . "search", [
            'jql' => "project = $projectKey",
            'maxResults' => 10,
        ]);

        if ($response->failed()) {
            throw new \Exception('Не удалось получить данные от Jira: ' . $response->body());
        }

        return $response->json()['issues'];
    }

    public function createIssue($data)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authHeader,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($this->baseUri . "issue", $data);

        if ($response->failed()) {
            throw new \Exception('Ошибка при создании задачи в Jira: ' . $response->body());
        }

        return $response->json();
    }
}
