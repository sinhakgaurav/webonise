<?php

namespace App\Admin\Services;

use Core\Container;

class UserService {

    private $model;

    public function __construct() {
        /** @var App\Admin\Models\User model */
        $this->model = Container::getContainer()->get('admin.model.user');
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

    /*
     * function to call model
     * 
     * @ returns list of users
     */

    public function getUsers() {
        return $this->model->getUsers();
    }

    /*
     * function to call model
     * 
     * @ returns detailed list of users punchin 
     */

    public function getPunchin($data) {
        return $this->model->getPunchin($data);
    }

    /*
     * function to get users with their average punch in time
     * @returns array of users
     */

    public function getUsersWithDetails($data = null) {
        return $this->model->getUsersWithDetails($data);
    }

    /*
     * function to get users with their average punch in time by id
     * @returns array of user details
     */

    public function getUsersWithDetailsById($data) {
        return $this->model->getUsersWithDetailsById($data);
    }

    /*
     * function to get user with avg time , no of time late,and other details
     * @returns a array with user details
     */

    public function getUsersWithAllDetails($data = null) {
        return $this->model->getUsersWithAllDetails($data);
    }

    /*
     * function to call model to delete user
     * @return boolean
     */

    public function deleteUser($data) {
        return $this->model->deleteUser($data);
    }

}
