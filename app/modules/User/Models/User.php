<?php

namespace App\User\Models;

use Core\Container;

class User {

    private $repository;

    public function __construct() {

        /** @var App\User\Repository\UserRepository repository */
        $this->repository = Container::getContainer()->get('user.repository.user_repository');
    }

    public function getUser($data) {
        $user = $this->repository->getUser($data);
        if ($user) {
            $punchin = $this->repository->getUserPunchinById($user['id'], array('date' => date('Y-m-d')));
            
            if (empty($punchin)) {
                if ($this->repository->setPunchin($user['id'])) {
                    return $this->repository->getUserPunchinById($user['id'], array('date' => date('Y-m-d')));
                }
            } else {
                
                $_SESSION['error'][] = "Don't worry!! You are already inside.";
                return false;
            }
        }
    }

    public function registerUser($data) {
        if ($this->repository->getUser($data)) {
            return false;
        }
        if($this->repository->registerUser($data)){
            return $this->repository->getUser($data);
        }
    }

}
