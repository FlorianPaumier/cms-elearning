<?php


namespace App\Core\Request;
use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;

/**
 * Class RedirectionHandler
 * @package App\Core\request
 */
class RedirectionHandler
{
    /**
     * Redirect the user to the given uri
     *
     * @param string $path
     */
    public function redirectTo(string $path)
    {
        header('Status: 301 Moved Permanently', false, 301);
        header("Location: ".$path);
        session_write_close();
        session_regenerate_id(true);
        die();
    }

    /**
     * Redirect the to the route reffered to the route name
     *
     * @param string $name
     * @throws \Exception
     */
    public function redirectToRoute(string $name, array $params = [])
    {
        $route = ConfigHandler::get("router")->getPath($name, $params);

        if (is_null($route)) {
            throw new \Exception("La route $name n'a pas été trouvé");
        }


        $this->redirectTo($route);
    }

    /**
     * Get the HTTP_REFERER
     */
    public function getPreviousPath()
    {
    }
}