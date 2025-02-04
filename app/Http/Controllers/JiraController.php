<?php

namespace App\Http\Controllers;

use App\Services\JiraService;
use Illuminate\Http\Request;

class JiraController extends Controller
{
    protected $jiraService;

    public function __construct(JiraService $jiraService)
    {
        $this->jiraService = $jiraService;
    }

    public function index()
    {
        $projectKey = 'Test';
        $issues = $this->jiraService->getIssues($projectKey);
        return view('jira.index', ['issues' => $issues, 'projectKey' => $projectKey, 'status' => 'success']);
    }
}
