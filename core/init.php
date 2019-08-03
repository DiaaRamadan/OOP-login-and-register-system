<?php
session_start();

// Start the project fonfig
$GLOBALS['config'] = array(

    // database config
    "mysql" => array(

        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db_name' => 'oop-login-register',
    ),

    // login remember user config
    'remember' => array(

        'cookie_name' => 'hash',
        'cookie_expire' => 604800,
    ),

    // Start session config

    'session' => array(

        'session_name' => 'user',
    ),

);

// Autoload function to make required all classes

spl_autoload_register(function ($class){

    require_once "classes/" . $class. ".php";

});

// require the sanitize function

require_once "functions/sanitize.php";