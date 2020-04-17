<?php

//Our autoloader function.
function autoloader($className)
{
    //Split the class name up if it contains backslashes.
    $classNameParts = explode('\\', $className);
    //The last piece of the array will be our class name.
    array_shift($classNameParts);
    array_unshift($classNameParts, ROOT_PATH . "/src");
    //Include the class.
    $file = implode("/", $classNameParts) . '.php';
    if(file_exists($file)){
        include $file;
    }
}

//Tell PHP what our autoloading function is.
spl_autoload_register('autoloader');