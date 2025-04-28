<?php

namespace App\Http\Controllers;

use App\Services\JiraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JiraController extends Controller
{
    protected JiraService $jiraService;

    public function __construct(JiraService $jiraService)
    {
        $this->jiraService = $jiraService;
    }

    public function index()
    {
        $projectKey = 'Test';

        try {
            $issues = $this->jiraService->getIssues($projectKey);

            return view('jira.index', [
                'issues' => $issues,
                'projectKey' => $projectKey,
                'status' => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error('Ошибка получения задач из Jira: ' . $e->getMessage());

            return view('jira.index', [
                'issues' => [],
                'projectKey' => $projectKey,
                'status' => 'error',
                'message' => 'Не удалось загрузить задачи из Jira. Пожалуйста, попробуйте позже.',
            ]);
        }
    }
}
