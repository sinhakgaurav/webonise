<?php

namespace App\User\Repository;

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
        return $this->dbManager->read_query('SELECT * FROM user where user_name="' . $data['username'] . '"');
    }

    public function registerUser($data) {
        return $this->registerUserQuery($data);
    }

    private function registerUserQuery($data) {
        return $this->dbManager->write_query('INSERT INTO user SET user_name="' . $data['username'] . '",status="1",created=NOW()');
    }

    public function setPunchin($data) {
        return $this->setPunchinQuery($data);
    }

    private function setPunchinQuery($data) {
        return $this->dbManager->write_query('INSERT INTO user_signin SET user_id="' . $data . '",time_entered=NOW(),created=NOW()');
    }
    
    /*
     * function to get user punchin by id
     * @returns array of user punchin
     */

    public function getUserPunchinById($userId, $data = null) {
        $userPunch= $this->getUserPunchinByIdQuery($userId, $data);
        return $userPunch->fetch_assoc();
    }

    private function getUserPunchinByIdQuery($userId, $data) {
        $condition = '';
        if (isset($data['date'])) {
            $condition = 'AND created="' . $data['date'] . '"';
        }
        return $this->dbManager->read_query('SELECT * from user_signin where user_id="' . $userId . '" '.$condition);
    }

}
