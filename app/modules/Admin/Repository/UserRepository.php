<?php

namespace App\Admin\Repository;

use Core\Repository;

class UserRepository extends Repository {

    private $dbManager;

    public function __construct() {
        $this->dbManager = $this->getDb();
    }

    public function getUser($data) {
        $userQuery = $this->getUserQuery($data);

        return $userQuery->fetch_assoc();
    }

    private function getUserQuery($data) {
        return $this->dbManager->read_query('SELECT * FROM admin where user_name="' . $data['username'] . '" AND password="' . md5($data['password']) . '"');
    }

    public function getUsers($dataRow=null,$startFrom=0,$rowNum=0) {
        $returnData = array();
        $usersQuery = $this->getUsersQuery($dataRow,$startFrom,$rowNum);
        if ($usersQuery) {
            while ($data = $usersQuery->fetch_assoc()) {
                $returnData[$data['id']] = $data;
            }
        }
        return $returnData;
    }

    private function getUsersQuery($dataRow,$startFrom,$rowNum) {
        $limit='';
        if($rowNum!=0){
            $limit.=' limit '.$startFrom.','.$rowNum;
        }
        return $this->dbManager->read_query('SELECT * FROM user WHERE status="1" '. $limit);
    }

    public function getPunchin($data = null) {
        $count = 0;
        $totalTime = 0;
        $returnData=array();
        $usersQuery = $this->getPunchinQuery($data);
        if ($usersQuery) {
            while ($data = $usersQuery->fetch_assoc()) {
                $returnData[] = $data;
                $totalTime+=strtotime($data['time_entered']);
                $count++;
            }
            if(count($returnData)>0)
            $returnData['averageInTime'] = date('h:i a', (int) $totalTime / $count);
        }
        return $returnData;
    }

    private function getPunchinQuery($data) {
        return $this->dbManager->read_query('SELECT user_signin.* FROM user INNER JOIN user_signin ON user.id=user_signin.user_id where user_signin.created="' . $data['date'] . '" AND  user.status="1" GROUP BY user.id');
    }

    /*
     * function to get users with their average punch in time
     * @returns array of user
     */

    public function getUsersWithDetails($data,$startFrom,$rowNum) {
        return $this->getUsers($data,$startFrom,$rowNum);
    }

    /*
     * function to get users with their average punch in time by id
     * @returns array of user details
     */

    public function getUsersWithDetailsById($data) {
        $userQuery = $this->getUsersWithDetailsByIdQuery($data);
        return $userQuery->fetch_assoc();
    }

    private function getUsersWithDetailsByIdQuery($data) {
        return $this->dbManager->read_query('SELECT * FROM user where id="' . $data . '" AND  user.status="1"');
    }

    /*
     * function to get user punchin by id
     * @returns array of user punchin
     */

    public function getUserPunchinById($userId, $data = null) {
        return $this->getUserPunchinByIdQuery($userId, $data);
    }

    private function getUserPunchinByIdQuery($userId, $data) {
        $condition = '';
        if (isset($data['date'])) {
            $condition = 'AND created="' . $data['date'] . '"';
        }
        return $this->dbManager->read_query('SELECT * from user_signin where user_id="' . $userId . '" '.$condition);
    }

    /*
     * function to return list of users with their average in time and count of late days
     * @returns a array to model
     */

    public function getUserListByType($data = NULL,$startFrom=0,$rowNum=0) {
        $returnData = array();
        $usersQuery = $this->getUserListByTypeQuery($data,$startFrom,$rowNum);
        if ($usersQuery) {
            while ($dataReturn = $usersQuery->fetch_assoc()) {
                $returnData[] = $dataReturn;
            }
        }
        return $returnData;
    }

    public function getUserListByTypeQuery($data,$startFrom=0,$rowNum=0) {
        $orderBy = "";
        $limit='';
        if($rowNum!=0){
            $limit.=' limit '.$startFrom.','.$rowNum;
        }
        if (isset($data['sort_by']) && $data['sort_by'] == "userByLateCount") {
            $orderBy = " order by late_count desc";
        }
        if (isset($data['sort_by']) && $data['sort_by'] == "userByAverageTime") {
            $orderBy = " order by average_arrival desc";
        }
        if (isset($data['sort_by']) && $data['sort_by'] == "userByAlphabeticalOrder") {
            $orderBy = " order by user_name asc";
        }
        return $this->dbManager->read_query('SELECT u.*,sec_to_time(AVG(time_to_sec(us.`time_entered`))) AS average_arrival, 
            SUM(IF(TIME(us.`time_entered`) > TIME("10:00:00") ,1,0)) AS late_count FROM `user` AS u LEFT OUTER JOIN user_signin AS us ON u.id=us.user_id where status="1" GROUP BY u.id ' . $orderBy." ".$limit);
    }

    /*
     * function to update the status to 2 for the userid
     * @returns boolean
     */

    public function deleteUser($data) {
        return $this->deleteUserQuery($data);
    }

    private function deleteUserQuery($data) {
        return $this->dbManager->write_query('UPDATE user SET status="2" where id="' . $data . '"');
    }

}
