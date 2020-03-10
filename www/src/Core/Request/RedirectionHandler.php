<?php


namespace App\Core\request;
use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;

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
        exit();
    }

    /**
     * Redirect the to the route reffered to the route name
     *
     * @param string $name
     */
    public function redirectToRoute(string $name)
    {
        $route = CacheHandler::get("routing")[$name];

        if(is_null($route)){
            throw new \Exception("La route $name n'a pas été trouvé");
        }
        $this->redirectTo($route["path"]);
    }

    /**
     * Get the HTTP_REFERER
     */
    public function getPreviousPath()
    {
    }
}