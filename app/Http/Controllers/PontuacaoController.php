<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\ActivityService;
use DateTime;

class PontuacaoController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function geral(Request $request): Response
    {
        $start_date = date('Y-m-d', strtotime('last monday'));
        $end_date = date('Y-m-d', strtotime('next saturday'));
        $userActivities = [];

        $user_ids = [
            '15129511',
            '15129907',
            '15441515',
            '14935141',
            '12907661',
            '13711853',
            '13320209'
        ];

        foreach ($user_ids as $user_id) {
            $userActivities[$user_id] = $this->activityService->getUserActivities($user_id, $start_date, $end_date);
        }

        return Inertia::render(
            'Pontuacao/pontuacaoGeral',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );
    }

    public function atualizar(Request $request)
    {
        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        $end_date = new DateTime($end_date);
        $end_date->modify('+1 day');

        $user_ids = [
            '15129511',
            '15129907',
            '15441515',
            '14935141',
            '12907661',
            '13711853',
            '13320209'
        ];

        foreach ($user_ids as $user_id) {
            $userActivities[$user_id] = $this->activityService->getUserActivities($user_id, $start_date, $end_date->format('Y-m-d'));
        }

        return Inertia::render(
            'Pontuacao/pontuacaoGeral',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );
    }
}