<?php

namespace App\Http\Services;

class DateService
{
    public function getStartDate()
    {
        // Yesterday
        $startDate = new \DateTime(date('Y-m-d', strtotime('-1 day')));

        return $startDate;
    }

    public function getEndDate()
    {
        // 3 months from now
        $endDate = new \DateTime(date('Y-m-d', strtotime('+3 months')));

        return $endDate;
    }

    public function generateDateRange(\DateTime $startDate, \DateTime $endDate)
    {
        $dates = [];
        for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
            $dates[] = clone $date;
        }

        return $dates;
    }
}