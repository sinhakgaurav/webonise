<?php

namespace App\User\Controllers;

use Core\Container;
use Core\Controller;

/**
 * The default home controller, called when no controller/method has been passed
 * to the application.
 */
class Home extends Controller {

    private $service;

    public function __construct() {
        /** @var \App\User\Services\UserService service */
        $this->service = Container::getContainer()->get('user.service.user_service');
    }

    /**
     * The default controller method.
     *
     * @return void
     */
    public function index() {
        if ($_POST) {
            if($this->validate($_POST)){
            $user = $this->service->getUser($_POST);
            if($user){
            //var_dump($user);
                if(strtotime($user['time_entered'])>  strtotime('10:00:00')){
                    $_SESSION['error'][]="We expected you to arrive a bit early(atmost by 10AM)!!! ";
                }else{
                    $_SESSION['success'][]="Welcome!!! That's good to return early. Time logged!!";
                }
            
            }else{
                $_SESSION['error'][]="Something missed!! You were not found. Please register to continue.";
            }
            }
        }
        $this->view(
                'user.index', [
                ]
        );
    }

    public function register() {
        if ($_POST) {
            if($this->validate($_POST)){
            $user = $this->service->registerUser($_POST);
            if(!$user){
                $_SESSION['error'][]="You are already a part. hahaha!!!";
            }else{
                $_SESSION['success'][]="Welcome!!! Be comfortable and enjoy being at home.";
            }
            }
        }
        $this->view(
                'user.register', [
                ]
        );
    }

}
