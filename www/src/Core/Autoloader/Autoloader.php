<?php
class Autoloader {
    static public function loader($className) {
        $namespace = explode("\\", $className);
        array_shift($namespace);
        $filename = ROOT_DIR.DS."src/" . implode('/', $namespace) . ".php";
        if (file_exists($filename)) {
            include($filename);
            if (class_exists($className)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('Autoloader::loader');