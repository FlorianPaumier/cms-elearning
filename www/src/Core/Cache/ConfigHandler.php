<?php


namespace App\Core\Cache;


use App\Core\Cache\CacheHandler;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Table;
use App\Core\Events\EventEmmiter;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Logger\AbstractLogger;
use App\Core\Request\Request;
use App\Core\Router\Router;
use App\Core\Security\UserManager;
use App\Core\Session\PHPSession;
use App\Core\Kernel\Kernel;

class ConfigHandler
{
    /**
     * path to the configuration directory
     *
     * @var array
     */
    private $path;

    /*
     * The container application
     */
    protected static $container = [];

    public function __construct()
    {
        define("VIEW_PATH", ROOT_PATH . "/public/views");
        define("FORM_PATH", ROOT_PATH . "/src/Core/Form");
        define("CACHE_PATH", ROOT_PATH . "/app/cache");
        define("CONFIG_PATH", ROOT_PATH . "/app/config");
        define("ROUTING_PATH", ROOT_PATH . "/app/routing");
        define("PATH_STYLE", ROOT_PATH . "/public/styles");
        define("PATH_SCRIPT", ROOT_PATH . "/public/scripts");
        define("PATH_LIBRARY", ROOT_PATH . "/node_modules");
    }


    /**
     * This function is call when a web application is start
     * Put all the  default class to  make the app working
     */
    public function init()
    {

        $this->getConfig();
        $this->getRouting();

        self::bind("request", Request::createFromGlobals());
        self::bind("session", new PHPSession());
        self::bind("exception", new ExceptionHandler());
        self::bind("repository", new Table());
        self::bind("entityManager", new QueryBuilder());
        //self::bind("container", new DependencyInjection());
        self::bind("userManager", new UserManager());
        self::bind("router", new Router());
        self::bind("logger", AbstractLogger::getInstance());
        self::bind("eventEmmiter", EventEmmiter::getInstance());

    }

    /**
     * Set the value in the container
     *
     * @param string $key
     * @param $value
     */
    public static function bind(string $key, $value)
    {
        self::$container[$key] = $value;
    }

    /**
     * Get the value from the container
     *
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if (key_exists($key, self::$container)) {
            return self::$container[$key];
        }

        return null;
    }

    /**
     * This function is call when a command is start
     * Put all the  default class to  make the app working
     */
    public function minimal()
    {
        self::bind("config", CacheHandler::set("config", yaml_parse_file($this->path["config"] . "/config.yml")));
    }

    /**
     * Get the data from the configuration in the config dir
     */
    private function getConfig()
    {
        $config = dirToArray(CONFIG_PATH);

        foreach ($config as $file) {
            $name = explode(".", $file)[0];
            CacheHandler::set($name, yaml_parse_file(CONFIG_PATH . "/" . $file));
        }
    }

    /**
     * Get the data from the routing dir in the routing dir
     */
    private function getRouting()
    {

        $routing = [];

        foreach (dirToArray(ROUTING_PATH) as $key => $file) {
            $table = [];
            if (is_int($key)) {
                $table = yaml_parse_file(ROUTING_PATH . "/$file");
            } else {
                foreach ($file as $route) {
                    $dir = dirToArray(ROUTING_PATH . "/$key");
                    foreach ($dir as $dirFile) {
                        $table = array_merge($table, yaml_parse_file(ROUTING_PATH . "/$key/$dirFile"));
                    }
                }
            }
            if (!is_null($table)) {
                $routing = array_merge($routing, $table);
            };
        };

        CacheHandler::set("routing", $routing);
    }

}