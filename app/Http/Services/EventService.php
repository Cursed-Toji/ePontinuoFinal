<?php

namespace App\Http\Services;

class EventService
{
    public function createScheduledEvents(\DateTime $startDate, \DateTime $endDate, array $userNames)
    {
        $activityHours = [9, 10, 11, 14, 15, 16, 17];
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
                    'OwnerText' => implode(', ', $userNames),
                    'OwnerColor' => '#008000'
                ];
                $id++;
            }
        }

        return $schedEvents;
    }

    public function updateScheduledEvents(array $schedEvents, array $activities, string $username)
    {
        // Map due_time to hour
        $dueTimeToHour = [
            '12:00' => '09',
            '13:00' => '10',
            '14:00' => '11',
            '17:00' => '14',
            '18:00' => '15',
            '19:00' => '16',
            '20:00' => '17'
        ];

        foreach ($activities as $activity) {


            if ($activity['type'] == 'caso_critico_') {
                $dueDate = $activity['due_date'];
                foreach ($schedEvents as &$schedEvent) {
                    $schedEventDate = $schedEvent['StartTime']->format('Y-m-d');
                    if ($schedEventDate == $dueDate) {
                        $ownerTextArray = explode(', ', $schedEvent['OwnerText']);
                        $key = array_search($username, $ownerTextArray);
                        if ($key !== false) {
                            unset($ownerTextArray[$key]);
                            $schedEvent['OwnerText'] = implode(', ', $ownerTextArray);
        
                            // Update the Subject attribute
                            $numVagas = intval(explode(' ', $schedEvent['Subject'])[0]) - 1;
                            $schedEvent['Subject'] = $numVagas . " vagas disponíveis";
        
                            // Update the OwnerColor attribute based on the number of vagas
                            $schedEvent['OwnerColor'] = $this->getOwnerColor($numVagas);
                        }
                    }
                }
                continue;
            }



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
                    // Convert OwnerText to array
                    $ownerTextArray = explode(', ', $schedEvent['OwnerText']);

                    // Find the key of the username in the OwnerText array
                    $key = array_search($username, $ownerTextArray);

                    // If the username is found, remove it
                    if ($key !== false) {
                        unset($ownerTextArray[$key]);

                        // Update the OwnerText attribute
                        $schedEvent['OwnerText'] = implode(', ', $ownerTextArray);

                        // Update the Subject attribute
                        $numVagas = intval(explode(' ', $schedEvent['Subject'])[0]) - 1;
                        $schedEvent['Subject'] = $numVagas . " vagas disponíveis";

                        // Update the OwnerColor attribute based on the number of vagas
                        $schedEvent['OwnerColor'] = $this->getOwnerColor($numVagas);
                    }

                    break;
                }
            }
        }

        return $schedEvents;
    }

    private function getOwnerColor(int $numVagas)
    {
        switch ($numVagas) {
            case 7:
                return '#008000';
            case 6:
                return '#32a852';
            case 5:
                return '#66b104';
            case 4:
                return '#99ba56';
            case 3:
                return '#cdc408';
            case 2:
                return '#ffbf00';
            case 1:
                return '#ff6100';
            case 0:
                return '#ff0000';
            default:
                return '#008000';
        }
    }
}