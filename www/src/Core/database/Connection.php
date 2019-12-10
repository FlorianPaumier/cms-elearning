<?php

namespace App\Core\Database;

use App\Core\Kernel\Kernel;

abstract class Connection
{

    private static $connection;
    /**
     * Call this method to get singleton
     */
    public static function instance()
    {
        if( self::$connection === null )
        {
            // Late static binding (PHP 5.3+)
            $config = Kernel::get("config")["database"];
            $dsn = "${config['driver']}:host=${config['host']};dbname=${config['dbname']}";

            try{
                self::$connection = new \PDO($dsn, $config["username"], $config["password"]);
            }catch (\PDOException $e){
                echo $e->getMessage();
                exit();
            }
        }

        return self::$connection;
    }

    /**
     * Make constructor private, so nobody can call "new Class".
     */
    private function __construct() {}

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone() {}

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep() {}

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup() {}

}