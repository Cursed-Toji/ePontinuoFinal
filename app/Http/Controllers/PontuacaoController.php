<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Services\PipedriveAPI;
use DateTime;



class PontuacaoController extends Controller
{
    public function geral(Request $request): Response
    {

        $pipedriveAPI = new PipedriveAPI();

        $start_date = date('Y-m-d', strtotime('last monday'));
        $end_date = date('Y-m-d', strtotime('next saturday'));


        $user_ids = [
            '15129511',
            '15129907',
            '15441515',
            '14935141',
            '12907661',
            '13711853',
            '13320209'
        ];


        $listaTiposAtividades = [
            'imp_acessorias_etapa_i',
            'imp_etapa_ii',
            'imp_acessorias_etapa_iii',
            'imp_acessorias_etapa_iv',
            'imp_etapa_iii',
            'treinamento_adicional',
            'imp_komunic_',
            'task',
            'call',
            'chat',
            'acompanhamento_',
            'loja_apple_',
            'reagendar',
            'ps_venda',
            'komunic',


        ];

        $userActivities = [];
        $start_date = date('Y-m-d', strtotime('last monday'));
        $end_date = date('Y-m-d', strtotime('next saturday'));





        foreach ($user_ids as $user_id) {
            $userActivities[$user_id] = array_fill_keys($listaTiposAtividades, 0);
        }

        foreach ($user_ids as $user_id) {
            error_log($start_date);
            error_log($end_date);
            $data = $pipedriveAPI->getActivities($user_id, $start_date, $end_date, "1");
            if (isset($data)) {
                error_log("Data is OK");
            } else {
                error_log("Data is null");
            }

            foreach ($data as $activity) {
                if (in_array($activity['type'], $listaTiposAtividades)) {
                    $userActivities[$user_id][$activity['type']]++;
                }
            }
        }

        error_log(json_encode($userActivities, JSON_PRETTY_PRINT));

        return Inertia::render(
            'Pontuacao/pontuacaoGeral',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );
    }

    public function atualizar(Request $request)
    {
        $pipedriveAPI = new PipedriveAPI();

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

        $listaTiposAtividades = [
            'imp_acessorias_etapa_i',
            'imp_etapa_ii',
            'imp_acessorias_etapa_iii',
            'imp_acessorias_etapa_iv',
            'imp_etapa_iii',
            'treinamento_adicional',
            'imp_komunic_',
            'task',
            'call',
            'chat',
            'acompanhamento_',
            'loja_apple_',
            'reagendar',
            'ps_venda',
            'komunic',
        ];

        foreach ($user_ids as $user_id) {
            $userActivities[$user_id] = array_fill_keys($listaTiposAtividades, 0);
        }

        foreach ($user_ids as $user_id) {
            $start = new DateTime($start_date);
            $end = $end_date;
            $interval = $start->diff($end);
            $days = $interval->days;
            $data_sets = [];

            if ($days > 14) {
                $period = round($days / 3);
                $middle_date1 = clone $start;
                $middle_date1->modify("+$period days");
                $middle_date2 = clone $middle_date1;
                $middle_date2->modify("+$period days");

                // Now make three requests with the divided date ranges
                $data_sets[] = $pipedriveAPI->getActivities($user_id, $start->format('Y-m-d'), $middle_date1->format('Y-m-d'), "1");
                sleep(1); // Delay for 1 second
                $data_sets[] = $pipedriveAPI->getActivities($user_id, $middle_date1->format('Y-m-d'), $middle_date2->format('Y-m-d'), "1");
                sleep(1); // Delay for 1 second
                $data_sets[] = $pipedriveAPI->getActivities($user_id, $middle_date2->format('Y-m-d'), $end->format('Y-m-d'), "1");
                foreach ($data_sets as $data) {
                    foreach ($data as $activity) {
                        if (in_array($activity['type'], $listaTiposAtividades)) {
                            $userActivities[$user_id][$activity['type']]++;
                        } else {
                            continue;
                        }
                    }
                }

            } else {
                // If the date difference is not more than 14 days, make a single request
                $data_sets = [$pipedriveAPI->getActivities($user_id, $start->format('Y-m-d'), $end->format('Y-m-d'), "1")];
                error_log('Data collected');
                foreach ($data_sets as $data) {
                    if (!isset($data) || empty($data)) {
                        continue;
                    }
                    foreach ($data as $activity) {
                        if (in_array($activity['type'], $listaTiposAtividades)) {
                            $userActivities[$user_id][$activity['type']]++;
                        } else {
                            continue;
                        }
                    }
                }
            }
            ;
        }
        ;


        return Inertia::render(
            'Pontuacao/pontuacaoGeral',
            ['userActivities' => $userActivities, 'csrfToken' => csrf_token()]
        );

    }
}