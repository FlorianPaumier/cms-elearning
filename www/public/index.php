<?php

session_start();
use App\Core\Kernel\Kernel;

define("ROOT_PATH", dirname(__DIR__));

require ROOT_PATH.'/src/Core/Helpers/autoloader.php';

if(file_exists(ROOT_PATH."/app/config/config.yml")) {
//Define ENV TYPE from configuration file
    $env = yaml_parse_file(ROOT_PATH."/app/config/config.yml")["env"];
} else {
    $env = "dev";
}

$debug = false;

/**
 * If env is dev, enable display error and make application to development work
 */
if($env == "dev"){
    $debug=true;
    //Display All Php errors
    ini_set('display_errors', true);
}

//Create new Environment
$kernel = new Kernel($env, $debug);
//Prepare all default value
$kernel->init();

//Process the request
$kernel->resolve();
