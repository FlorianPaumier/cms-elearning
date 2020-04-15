<?php

use App\Core\Kernel\Kernel;

define("ROOT_PATH", dirname(__DIR__));
define("DEFAULT_VIEW_DIR", dirname(__DIR__) . "/public/views");

require ROOT_PATH . '/src/Core/Helpers/autoloader.php';

//Define ENV TYPE
$env = "dev";

if ($env == "dev") {
    $debug = true;
    //Display All Php errors
    ini_set("display_errors", 1);
}

//Create new Environment
$kernel = new Kernel($env, $debug);

//Prepare all default value
$kernel->init();

//Process the request
Kernel::resolve();
