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
            $start_date = $request->input('monday');
            $end_date = $request->input('saturday');
        } else {
            // Default start and end dates for GET requests
            $start_date = date('Y-m-d', strtotime('last monday'));
            $end_date = date('Y-m-d', strtotime('next saturday'));
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

        $weekdays = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday'
        ];

        $trainings = [
            'treinamento_um',
            'treinamento_dois',
            'treinamento_tres',
            'treinamento_quatro'
        ];

        $weekData = [];
        foreach ($weekdays as $day) {
            $weekData[$day] = array_fill_keys($trainings, 7);
        }

        foreach ($user_ids as $user_id) {
            $data = $pipedriveAPI->getActivities($user_id, $start_date, $end_date);

            $seenDatesTimes = [];

            foreach ($data as $activity) {
                if (in_array($activity['type'], $listaTiposAtividades)) {
                    $weekday = date('l', strtotime($activity['due_date']));
                    $dateTimeKey = $weekday . $activity['due_time'];
                    if (isset($weekData[$weekday]) && !isset($seenDatesTimes[$dateTimeKey])) {
                        switch ($activity['due_time']) {
                            case '12:00':
                                $weekData[$weekday]['treinamento_um']--;
                                break;
                            case '13:00':
                            case '13:30':
                                $weekData[$weekday]['treinamento_dois']--;
                                break;
                            case '17:00':
                                $weekData[$weekday]['treinamento_tres']--;
                                break;
                            case '19:00':
                                $weekData[$weekday]['treinamento_quatro']--;
                                break;
                        }
                        $seenDatesTimes[$dateTimeKey] = true;
                    }
                }
            }
        }

        error_log(json_encode($weekData, JSON_PRETTY_PRINT));


        return Inertia::render('Pipedrive/Index', ['weekData' => $weekData]);
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
