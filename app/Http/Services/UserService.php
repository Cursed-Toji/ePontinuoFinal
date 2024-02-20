<?php

namespace App\Http\Services;

class UserService
{
    public function getUserNames()
    {
        // Map user IDs to names
        $userNames = [
            '15129511' => 'João',
            '15129907' => 'Luiz',
            '15441515' => 'Matheus',
            '14935141' => 'Felipe',
            '12907661' => 'Volnei',
            '13711853' => 'Thomas',
            '13320209' => 'Lucas'
        ];

        return $userNames;
    }
}