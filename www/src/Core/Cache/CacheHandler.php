<?php
namespace App\Core\Cache;

abstract class CacheHandler
{

    private static $configFile = ["config", "routing", "security", "subscriber", "dashboard"];

    public static function set(string $key, $data)
    {
        $cacheFile = CACHE_PATH."/".md5($key)."Cache.php";

        if($_SERVER["APP_ENV"] == "dev" && !in_array($key, self::$configFile)){
            return null;
        }

        try{
            file_put_contents($cacheFile, "<?php \n return ".var_export($data, true) .";");
            return $data;
        }catch (\Exception $e){
            throw new \Exception("Cache couldn't be create");
        }
    }

    /**
     * Retrieve the cached data
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key){

        if(file_exists(CACHE_PATH."/".md5($key)."Cache.php")){
            return include CACHE_PATH."/".md5($key)."Cache.php";
        }

        return null;
    }

    public static function exist(string $key)
    {
        return file_exists(CACHE_PATH."/".md5($key)."Cache.php");
    }

    public function clear(){}
}