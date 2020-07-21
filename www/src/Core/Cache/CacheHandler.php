<?php

namespace App\Core\Cache;

/**
 * Class CacheHandler
 * @package App\Core\Cache
 */
abstract class CacheHandler
{

    /**
     * @var string[]
     */
    private static $configFile = ["config", "routing", "security", "subscriber", "dashboard"];

    /**
     * Create a file cache for the data
     * @param string $key
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public static function set(string $key, $data)
    {
        $cacheFile = CACHE_PATH . "/" . md5($key) . "Cache.php";

        try {
            file_put_contents($cacheFile, "<?php \n return " . var_export($data, true) . ";");
            return $data;
        } catch (\Exception $e) {
            throw new \Exception("Cache couldn't be create");
        }
    }

    /**
     * Retrieve the cached data
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if (file_exists(CACHE_PATH . "/" . md5($key) . "Cache.php")) {
            return include CACHE_PATH . "/" . md5($key) . "Cache.php";
        }

        return null;
    }


    /**
     * @param string $key
     * @return bool
     */
    public static function exist(string $key)
    {
        return file_exists(CACHE_PATH . "/" . md5($key) . "Cache.php");
    }

    /**
     *
     */
    public function clear()
    {
    }
}