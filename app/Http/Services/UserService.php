<?php

namespace App\Http\Services;

class UserService
{
    public function getUserNames()
    {
        // Map user IDs to names
        $userNames = [
            '15129907' => 'Luiz',
            '15441515' => 'Matheus',
            '14935141' => 'Felipe',
            '12907661' => 'Volnei',
            '13711853' => 'Thomas',
            '13320209' => 'Lucas',
            '13547253' => 'João Victor',
            '13570001' => 'Leonardo',
        ];

        return $userNames;
    }
}