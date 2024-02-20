<?php

namespace App\Http\Services;

use DateTime;

class ActivityService
{
    protected $pipedriveAPI;

    public function __construct(PipedriveAPI $pipedriveAPI)
    {
        $this->pipedriveAPI = $pipedriveAPI;
    }

    public function getUserActivities($idAnalista, $start_date, $end_date)
    {
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

        $userActivities = array_fill_keys($listaTiposAtividades, 0);

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days;
        $data_sets = [];

        if ($days > 14) {
            $period = round($days / 3);
            $middle_date1 = clone $start;
            $middle_date1->modify("+$period days");
            $middle_date2 = clone $middle_date1;
            $middle_date2->modify("+$period days");

            $data_sets[] = $this->pipedriveAPI->getActivities($idAnalista, $start->format('Y-m-d'), $middle_date1->format('Y-m-d'), "1");
            sleep(1);
            $data_sets[] = $this->pipedriveAPI->getActivities($idAnalista, $middle_date1->format('Y-m-d'), $middle_date2->format('Y-m-d'), "1");
            sleep(1);
            $data_sets[] = $this->pipedriveAPI->getActivities($idAnalista, $middle_date2->format('Y-m-d'), $end->format('Y-m-d'), "1");
        } else {
            $data_sets[] = $this->pipedriveAPI->getActivities($idAnalista, $start->format('Y-m-d'), $end->format('Y-m-d'), "1");
        }

        foreach ($data_sets as $data) {
            if (isset($data)) {
                foreach ($data as $activity) {
                    if (in_array($activity['type'], $listaTiposAtividades)) {
                        $userActivities[$activity['type']]++;
                    }
                }
            }
        }

        return $userActivities;
    }
}