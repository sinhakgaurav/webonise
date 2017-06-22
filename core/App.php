<?php

namespace Core;

class App {

    /**
     * Stores the controller from the split URL
     *
     * @var string
     */
    protected $controller = 'home';

    /**
     * Stores the method from the split URL
     * @var string
     */
    protected $method = 'index';

    /**
     * Stores the parameters from the split URL
     * @var array
     */
    protected $params = [];

    public function __construct() {
        // Get broken up URL
        $url = $this->parseUrl();

        
        $moduleName = (!empty($url[0])) ? $url[0] : 'user';
        $controllerName = (!empty($url[1])) ? $url[1] : 'home';
        $actionName = (!empty($url[2])) ? $url[2] : 'index';

        $completePath = '../app/modules/' . ucfirst($moduleName) . '/Controllers/' . ucfirst($controllerName) . '.php';

        if (file_exists($completePath)) {
            $this->controller = 'App\\' . $moduleName . '\\Controllers\\' . $controllerName;
        }

        require_once $completePath;

        $this->controller = new $this->controller();
        if (isset($url[2])) {
            if (method_exists($this->controller, $url[2])) {
                $this->method = $url[2];

                unset($url[2]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Parse the URL for the current request. 
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

}
