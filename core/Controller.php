<?php

namespace Core;

class Controller {

    protected $requestData;

    public function __construct() {
        $this->setGet();
        $this->setPost();
    }

    /**
     * Render a view
     *
     *  string $viewName The name of the view to include
     *  array  $data Any data that needs to be available within the view
     *
     */
    public function view($viewName, $data) {
        $viewArray = explode('.', $viewName);
        $viewName = ucfirst($viewArray[0]) . '/Views/' . $viewArray[1];
        $message['message']=$this->getMessage();
        $data=  array_merge($data, $message);
        //var_dump($message);
        // Create a new view and display the parsed contents
        $view = new View($viewName, $data);

        // View makes use of the __toString magic method to do this
        echo $view;
    }

    /*
     * general login check function
     * @no params
     * @check session
     * @returns false/ true on session value
     */

    protected function checkLogin() {
        if (empty($_SESSION['admin']['detail'])) {
            $this->redirect("Location: /admin");
        }
        return true;
    }

    /*
     * allocate post array
     * @returns the post array
     */

    protected function setPost() {
        if ($_SERVER['REQUEST_TYPE'] == "POST" && !empty($_POST)) {
            $this->requestData = $_POST;
        }
    }

    /*
     * allocate get array
     * @returns the get array
     */

    protected function setGet() {
        if ($_SERVER['REQUEST_TYPE'] == "GET" && !empty($_GET)) {
            $this->requestData = $_GET;
        }
    }
    /*
     * redirects to some page
     * $url contains the path to redirect  
     */
    protected function redirect($url) {
        if ($url != null) {
            header('Location: ' . $url);
        }
    }
    
    /*
     * function to validate data
     * @sets a session array for the for error message 
     */
    protected function validate($data){
        if(!empty($data)){
            foreach($data AS $key=>$value){
                if(trim($value)==''){
                        $_SESSION['error'][]=  ucfirst($key) ." is blank. That's bad!!!";
                    }
                if($key=="username"){
                    
                    if(!preg_match("/^[a-zA-Z0-9]+$/", $value)){
                        $_SESSION['error'][]=  "Username cannot contain special or space characters";
                    }
                }
            }
            if(!empty($_SESSION['error'])>0){
                return false;
            }
            return true;
        }
    }
    
    private function getMessage() {
        $message='';
        //var_dump($_SESSION);
        if(!empty($_SESSION['success'])){
            $message='<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>';
            foreach($_SESSION['success'] AS $msg){
            $message.="<p class='message'>".$msg ."</p>";
            }
            $message.='</div>';
            unset($_SESSION['success']);
            
        }
        
        if(!empty($_SESSION['error'])){
            $message='<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>';
            foreach($_SESSION['error'] AS $msg){
            $message.="<p class='message'>".$msg ."</p>";
            }
            $message.='</div>';
            unset($_SESSION['error']);
        }
        return $message;
        
    }
    

}
