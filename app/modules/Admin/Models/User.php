<?php

namespace App\Admin\Models;

use Core\Container;

class User {

    private $repository;

    public function __construct() {

        /** @var App\Admin\Repository\UserRepository repository */
        $this->repository = Container::getContainer()->get('admin.repository.user_repository');
    }

    /*
     * get admin
     * @scope for admin login
     */

    public function getUser($data) {
        $user = $this->repository->getUser($data);
        if ($user) {
            return $user;
        }
        return array();
    }

    /*
     * function to call repository
     * 
     * @ returns list of users
     */

    public function getUsers() {
        return $this->repository->getUsers();
    }

    /*
     * function to call repository
     * 
     * @ returns detailed list of users punchin 
     */

    public function getPunchin($data) {
        return $this->repository->getPunchin($data);
    }

    /*
     * function to get users with their average punch in time
     * @returns array of user
     */

    public function getUsersWithDetails($data) {
        $users = $this->repository->getUsersWithDetails($data);
        $returnData = array();
        $count = 0;
        foreach ($users AS $user) {
            $timeCount = 0;
            $totalTime = 0;
            $returnData[$count] = $user;
            $punchIndata = $this->repository->getUserPunchinById($user['id'], $data);
            while ($dataPunch = $punchIndata->fetch_assoc()) {
                $returnData[$count]['punchin'][] = $dataPunch;
                $totalTime+=strtotime($dataPunch['time_entered']);
                $timeCount++;
            }
            if ($timeCount > 0) {
                $returnData[$count]['averageInTime'] = date('H:i a', (int) $totalTime / $timeCount);
            }

            $count++;
        }
        return $returnData;
    }

    /*
     * function to get users with their average punch in time by id
     * @returns array of user details
     */

    public function getUsersWithDetailsById($data) {
        $returnData = array();
        $userData = $this->repository->getUsersWithDetailsById($data);
        if ($userData) {
            $lateCount = 0;
            $timeCount = 0;
            $totalTime = 0;
            $returnData = $userData;
            $punchIndata = $this->repository->getUserPunchinById($userData['id'], $data);
            while ($dataPunch = $punchIndata->fetch_assoc()) {
                $returnData['punchin'][] = $dataPunch;
                $totalTime+=strtotime($dataPunch['time_entered']);
                if (strtotime($dataPunch['time_entered']) > strtotime("10:00")) {
                    $lateCount+=1;
                }
                $timeCount++;
            }
            $returnData['lateCount'] = $lateCount;
            if ($timeCount > 0) {
                $returnData['averageInTime'] = date('H:i a', (int) $totalTime / $timeCount);
            }
            $returnData['totalWorkingDays'] = $this->calculateDays(date('Y-m-d', strtotime($userData['created'])));
            $returnData['daysAbsent'] = $returnData['totalWorkingDays'] - $timeCount;
            $returnData['daysPresent'] = $timeCount;
        }
//        echo "<pre>";
//        var_dump($returnData);
        return $returnData;
    }

    /*
     * function to get user with avg time , no of time late,and other details
     * @returns a array with user details
     */

    public function getUsersWithAllDetails($data = null) {
        return $this->repository->getUserListByType($data);
    }

    /*
     * function to call repository to delete the user
     * @returns a boolean 
     */

    public function deleteUser($data) {
        return $this->repository->deleteUser($data);
    }

    private function calculateDays($date) {
        $start = strtotime($date);

        $count = 0;

        while (date('Y-m-d', $start) < date('Y-m-d')) {
            $count += (date('N', $start) != 0) && (date('N', $start) != 6) ? 1 : 0;
            $start = strtotime("+1 day", $start);
        }

        return $count+1;
    }

}
