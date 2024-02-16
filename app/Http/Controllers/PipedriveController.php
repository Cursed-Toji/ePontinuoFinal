<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\PipedriveAPI;

class PipedriveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {

        $pipedriveAPI = new PipedriveAPI();

        // Check if the request is a POST request
        if ($request->isMethod('post')) {
            // Get the start and end dates from the request
            $startDate = $request->input('monday');
            $endDate = $request->input('saturday');
        } else {
            // Default start and end dates for GET requests
            $start_date = date('Y-m-d', strtotime('last monday'));
            $endDate = date('Y-m-d', strtotime('next saturday'));
        }

        $listaTiposAtividades = [
            'imp_acessorias_etapa_i',
            'imp_etapa_ii',
            'imp_acessorias_etapa_iii',
            'imp_acessorias_etapa_iv',
            'imp_etapa_iii',
            'treinamento_adicional',
            'imp_komunic_',


        ];

        $user_ids = [
            '15129511',
            '15129907',
            '15441515',
            '14935141',
            '12907661',
            '13711853',
            '13320209'
        ];

        // Map user IDs to names
        $userNames = [
            '15129511' => 'joao.lima',
            '15129907' => 'luiz',
            '15441515' => 'matheus',
            '14935141' => 'felipe',
            '12907661' => 'volnei',
            '13711853' => 'thomas',
            '13320209' => 'lucas'
        ];

        $startDate = new \DateTime(date('Y-m-d', strtotime('-1 day'))); // Yesterday
        $endDate = new \DateTime(date('Y-m-d', strtotime('+3 months'))); // 3 months from now

        $activityHours = [9, 10, 14, 16];
        $id = 1;
        $schedEvents = [];

        for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
            foreach ($activityHours as $hour) {
                $schedEvents[] = [
                    'Id' => $id,
                    'Subject' => "7 vagas disponíveis",
                    'EventType' => 'CONFIRMED',
                    'StartTime' => (clone $date)->setTime($hour, 0),
                    'EndTime' => (clone $date)->setTime($hour + 1, 0),
                    'OwnerId' => $id,
                    'OwnerText' => implode(', ', $userNames)
                ];
                $id++;
            }
        }

        // Map due_time to hour
        $dueTimeToHour = [
            '12:00' => '09',
            '13:00' => '10',
            '17:00' => '14',
            '19:00' => '16'
        ];

        foreach ($userNames as $userId => $username) {
            // Fetch activities from Pipedrive API for the current user
            $activities = $pipedriveAPI->getActivities($userId, $startDate, $endDate, '0');

            foreach ($activities as $activity) {
                // If the key doesn't exist, skip this iteration
                if (!isset($dueTimeToHour[$activity['due_time']])) {
                    continue;
                }

                $hour = $dueTimeToHour[$activity['due_time']];
                $dueDate = $activity['due_date'];

                foreach ($schedEvents as &$schedEvent) {
                    $schedEventHour = $schedEvent['StartTime']->format('H');
                    $schedEventDate = $schedEvent['StartTime']->format('Y-m-d');

                    if ($schedEventHour == $hour && $schedEventDate == $dueDate) {
                        error_log("found");

                        // Convert OwnerText to array
                        $ownerTextArray = explode(', ', $schedEvent['OwnerText']);

                        // Find the key of the username in the OwnerText array
                        $key = array_search($username, $ownerTextArray);

                        // If the username is found, remove it
                        if ($key !== false) {
                            error_log('tá dando certo');
                            unset($ownerTextArray[$key]);

                            // Update the OwnerText attribute
                            $schedEvent['OwnerText'] = implode(', ', $ownerTextArray);

                            // Update the Subject attribute
                            $numVagas = intval(explode(' ', $schedEvent['Subject'])[0]) - 1;
                            $schedEvent['Subject'] = $numVagas . " vagas disponíveis";

                        }

                        break;
                    }
                }
            }
        }



        error_log('chegho aq');
        error_log(JSON_ENCODE($schedEvents) . "\n");

        return Inertia::render('Pipedrive/Index', [
            'schedEvents' => $schedEvents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
