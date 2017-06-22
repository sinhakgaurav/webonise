<?php

namespace App\Admin\Controllers;

use Core\Container;
use Core\Controller;

/**
 * The default home controller, called when no controller/method has been passed
 * to the application.
 */
class Home extends Controller {

    private $service;

    public function __construct() {
        /** @var \App\Admin\Services\UserService service */
        $this->service = Container::getContainer()->get('admin.service.user_service');
    }

    /**
     * The default controller method.
     * performs login
     * @return void
     */
    public function index() {
        if ($_POST) {
            if ($this->validate($_POST)) {
                $user = $this->service->getUser($_POST);
                if (!empty($user)) {
                    unset($user['password']);
                    $_SESSION['admin']['detail'] = $user;

                    $_SESSION['success'][] = "Welcome to your control section.";
                    //var_dump($_SESSION);die;
                    $this->redirect("/admin/home/dashboard");
                } else {
                    $_SESSION['error'][] = "You are trying to play with wrong details. That's bad !!!!";
                }
            }
        }
        $this->view(
                'admin.index', array()
        );
    }

    /*
     * dashboard view for the EMS Admin
     * @returns void
     */

    public function dashboard() {
        if ($this->checkLogin()) {
            if ($_POST) {
                $totalEmps = $this->service->getUsersWithDetails($_POST);
                $totalSignin = $this->service->getPunchin($_POST);
            } else {
                $totalEmps = $this->service->getUsersWithDetails(array('date' => date('Y-m-d')));
                $totalSignin = $this->service->getPunchin(array('date' => date('Y-m-d')));
            }
            if (count($totalSignin)) {
                $averageTime = isset($totalSignin['averageInTime']) ? $totalSignin['averageInTime'] : '';
                unset($totalSignin['averageInTime']);
                $this->view(
                        'admin.dashboard', [
                    'totalEmp' => count($totalEmps),
                    'totalEmps' => $totalEmps,
                    'signedIn' => count($totalSignin),
                    'notPresent' => count($totalEmps) - count($totalSignin),
                    'averageInTime' => $averageTime,
                    'currentStatDate' => isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'),
                    'currentDate' => date('Y-m-d')
                        ]
                );
            } else {
                $this->view(
                        'admin.dashboard', [
                    'currentStatDate' => isset($_POST['date']) ? $_POST['date'] : date('Y-m-d'),
                    'totalEmp' => count($totalEmps),
                    'totalEmps' => $totalEmps,
                ]);
            }
        }
    }

    /*
     * performs the logout activity
     * @return void
     * @redirects to login
     */

    public function logout() {
        unset($_SESSION['admin']);
        //die('dasd');
        $_SESSION['success'][] = "You have logged off. Come back soon!!!";
        $this->redirect('/admin');
    }

    /*
     * function to list users
     * @gets value from user table
     */

    public function showall() {

        if ($this->checkLogin()) {
            $selected = "";
            if ($_POST) {
                $totalEmp = $this->service->getUsersWithAllDetails($_POST);
                $selected = $_POST['sort_by'];
            } else {
                $totalEmp = $this->service->getUsersWithAllDetails();
            }
            //echo "<pre>";var_dump($totalEmp);
            $this->view(
                    'admin.userView', [
                'totalEmp' => $totalEmp,
                'selected' => $selected
                    ]
            );
        }
    }

    /*
     * function to get user view
     * @gets value from services 
     */

    public function viewDetail($param) {
        $paramArray = func_get_args();
        $userDetails = $this->service->getUsersWithDetailsById($paramArray[count($paramArray) - 1]);
        //print_r($userDetails);
        $this->view(
                'admin.viewDetail', [
            'details' => $userDetails
                ]
        );
    }

    /*
     * function to delete user user
     * @gets return as true and false
     */

    public function deleteUser() {
        $paramArray = func_get_args();
        if ($this->service->deleteUser($paramArray[count($paramArray) - 1])) {
            $_SESSION['success'][] = "One member had been left behind. So sad!!!";
            $this->redirect("/admin/home/showall");
        }
    }

}
