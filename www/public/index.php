<?php

session_start();

use App\Core\Kernel\Kernel;

define("ROOT_PATH", dirname(__DIR__));

require ROOT_PATH . '/src/Core/Helpers/autoloader.php';

//Define ENV TYPE
#Todo : Use config var
$env="dev";
ini_set('display_errors', true);
$debug = false;

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
Kernel::resolve();
