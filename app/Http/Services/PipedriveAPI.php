<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;


class PipedriveAPI
{
    private $base_url = "https://api.pipedrive.com/v1";

    public function getActivities($user_id = null, $startDate = null, $endDate = null, $done = null)
    {

        $params = [
            'user_id' => $user_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'done' => $done,
            'limit' => "30000000",
            'api_token' => "d0f27a8c3a00dbd3bab46ead2a6d3bfc7fec6aa7",
        ];

        $url = $this->base_url . '/activities?' . http_build_query($params);

        error_log($url);

        $response = Http::get($url)->json();

        if (!isset($response)) {
            error_log("Null Response");
            return [];
        }

        if ($response['success'] !== true) {
            error_log($response['error']);
            return [];
        }


        return $response['data'];

    }
    public function getImplantacoes($user_id = null, $startDate = null, $endDate = null, $done = null)
    {

        $params = [
            'user_id' => $user_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'done' => $done,
            'limit' => "30000000",
            'api_token' => "d0f27a8c3a00dbd3bab46ead2a6d3bfc7fec6aa7",
            'type' => 'caso_critico_,imp_acessorias_etapa_i,imp_etapa_ii,imp_acessorias_etapa_iii,imp_acessorias_etapa_iv,imp_etapa_iii,treinamento_adicional,imp_komunic_'
        ];

        error_log(json_encode($params));
        

        $url = $this->base_url . '/activities?' . http_build_query($params);

        error_log($url);

        $response = Http::get($url)->json();

        if (!isset($response)) {
            error_log("Null Response");
            return [];
        }

        if ($response['success'] !== true) {
            error_log($response['error']);
            return [];
        }

        return $response['data'];

    }
}


