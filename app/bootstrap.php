<?php

//start session
session_start();
// Root path for inclusion.
define('INC_ROOT', dirname(__DIR__));

$config = array('boundaryTime' => '10:00 am');

// Require composer autoloader
require_once INC_ROOT . '/vendor/autoload.php';

require_once INC_ROOT . '/app/config/dbConfig.php';

\Core\Container::loadDependency();

//
//
////Root URL
//define('HTTP_ROOT',
//    'http://'.$_SERVER['HTTP_HOST'].
//    str_replace(
//        $_SERVER['DOCUMENT_ROOT'],
//        '',
//        str_replace('\\', '/', INC_ROOT).'/public'
//    )
//);
