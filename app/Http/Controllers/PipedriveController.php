<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\UserService;
use App\Http\Services\DateService;
use App\Http\Services\EventService;
use App\Http\Services\PipedriveAPI;

class PipedriveController extends Controller
{
    protected $userService;
    protected $dateService;
    protected $eventService;
    protected $pipedriveAPI;

    public function __construct(UserService $userService, DateService $dateService, EventService $eventService, PipedriveAPI $pipedriveAPI)
    {
        $this->userService = $userService;
        $this->dateService = $dateService;
        $this->eventService = $eventService;
        $this->pipedriveAPI = $pipedriveAPI;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $userNames = $this->userService->getUserNames();

        $startDate = $this->dateService->getStartDate();
        $endDate = $this->dateService->getEndDate();

        $schedEvents = $this->eventService->createScheduledEvents($startDate, $endDate, $userNames);

        foreach ($userNames as $userId => $username) {
            $activities = $this->pipedriveAPI->getImplantacoes($userId, $startDate, $endDate, '0');

            $schedEvents = $this->eventService->updateScheduledEvents($schedEvents, $activities, $username);
        }

        return Inertia::render('Pipedrive/Index', [
            'schedEvents' => $schedEvents,
        ]);
    }

    // ... other methods ...
}