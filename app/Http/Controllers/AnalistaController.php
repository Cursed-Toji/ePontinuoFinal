<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\ActivityService; // Assuming you have this service
use DateTime;

class AnalistaController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function geral(Request $request): Response
    {
        $user = $request->user();
        $idAnalista = $user->idAnalista;

        $start_date = date('Y-m-d', strtotime('last monday'));
        $end_date = date('Y-m-d', strtotime('next saturday'));

        $userActivities = $this->activityService->getUserActivities($idAnalista, $start_date, $end_date);

        return Inertia::render(
            'Analista/analistaPontuacao',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );
    }

    public function atualizar(Request $request)
    {
        $user = $request->user();
        $idAnalista = $user->idAnalista;

        $start_date = $request->input('startDate');
        $end_date = $request->input('endDate');
        $end_date = new DateTime($end_date);
        $end_date->modify('+1 day');

        $userActivities = $this->activityService->getUserActivities($idAnalista, $start_date, $end_date->format('Y-m-d'));

        return Inertia::render(
            'Analista/analistaPontuacao',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );
    }
}