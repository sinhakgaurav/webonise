<?php

namespace App\User\Services;

use Core\Container;

class UserService {

    private $model;

    public function __construct() {
        /** @var App\User\Models\User model */
        $this->model = Container::getContainer()->get('user.model.user');
    }

    /*
     * function to call model
     * @data to identify the user
     * @ return user table data
     */

    public function getUser($data) {
        return $this->model->getUser($data);
    }

    /*
     * function to call model
     * @data to create the user
     * @ returns true/ false on creation of row
     */

    public function registerUser($data) {
        return $this->model->registerUser($data);
    }

}
