<?php


namespace App\Core\cache;


use App\Core\Database\QueryBuilder;
use App\Core\Database\Table;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Request\Request;
use App\Core\Router\Router;
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

    public function __construct()
    {
        /**
         * define default  configuration directory
         *
         * @var array path
         */
        $this->path = [
            "routing" => ROOT_DIR . "/app/routing",
            "config" => ROOT_DIR . "/app/config",
            "cache" => dirname(__DIR__, 2)."/app/cache",
        ];
    }

    /**
     * Return an array of the parsed yml
     *
     * @param  string $key
     * @return bool|mixed
     */
    public function get(string $key)
    {
        $file = $this->path["cache"]."/{$key}Cache.php";
        if(file_exists($file) && (filemtime($file) + 5*60*60) > time()) {
            return include $file;
        }
        return false;
    }

    /**
     * This function is call when a web application is start
     * Put all the  default class to  make the app working
     */
    public function init()
    {

        $this->getConfig();
        $this->getRouting();

        Kernel::bind("request", Request::createFromGlobals());
        Kernel::bind("session", new PHPSession());
        Kernel::bind("exception", new ExceptionHandler());
        Kernel::bind("entityManager", new Table());
        Kernel::bind("repository", new Table());
        //Kernel::bind("container", new DependencyInjection());
        //Kernel::bind("userManager", new UserManager());
        Kernel::bind("router", new Router());

    }

    /**
     * This function is call when a command is start
     * Put all the  default class to  make the app working
     */
    public function minimal()
    {
        Kernel::bind("config", $this->instanceCache("config", yaml_parse_file($this->path["config"]."/config.yml")));
    }

    /**
     * Get the configuration and making cache
     *
     * @param  string $key
     * @param  array  $data
     * @return array|bool|mixed
     */
    private function instanceCache(string $key, array $data)
    {

        if(($config = $this->get($key)) !== false) {
            return $config;
        }

        /**
         * Create a php file cache with an array
         */
        $file = ROOT_DIR."/app/cache/{$key}Cache.php";
        file_put_contents($file, "<?php \n\r return " .var_export($data, true).";");

        return $data;
    }

    /**
     * Get the data from the configuration in the config dir
     */
    private function getConfig()
    {
        $config = dirToArray($this->path["config"]);

        foreach ($config as $file){
            $name = explode(".", $file)[0];
            Kernel::bind($name, $this->instanceCache($name, yaml_parse_file($this->path["config"]."/".$file)));
        }
    }

    /**
     * Get the data from the routing dir in the routing dir
     */
    private function getRouting()
    {

        $routing = [];

        foreach (dirToArray($this->path["routing"]) as $key => $file) {
            $table = [];
            if(is_int($key)) {
                $table = yaml_parse_file($this->path["routing"]."/$file");
            }else{
                foreach ($file as $route){
                    $dir = dirToArray($this->path["routing"]."/$key");
                    foreach ($dir as $dirFile) {
                        $table = array_merge($table, yaml_parse_file($this->path["routing"]."/$key/$dirFile"));
                    }
                }
            }
            if(!is_null($table)) {$routing = array_merge($routing, $table);
            };
        };

        Kernel::bind("routing", $this->instanceCache("routing", $routing));
    }

}