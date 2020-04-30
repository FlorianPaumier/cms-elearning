<?php

namespace App\Core\Router;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Kernel\Kernel;
use App\Core\Request\Request;

class Router
{
    /** @var array */
    private $routes;

    /** @var array */
    private $matchRoute;

    /**
     * @var string
     */
    private $uri;

    /** @var array */
    private $uriArray;

    /** @var Request */
    private $request;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = CacheHandler::get("routing");
        $this->request = ConfigHandler::get("request");
    }

    /**
     * Try to match with some route in the configuration
     * @return bool
     * @throws \Exception
     */
    public function match(): bool
    {
        /**
         * Retrive Uri
         * / | /url
         */
        $this->formatUrl();

        foreach ($this->routes as $route) {
            if ($this->hadParams($route["path"])) {
                if ($this->matchComplexRoute($route)) {
                    break;
                };
            } else {
                if ($this->uri === $route["path"]) {
                    $this->matchRoute = $route;
                    break;
                }
            }
        }

        if (!isset($this->matchRoute["method"]) || in_array($this->request->getMethod(), $this->matchRoute["method"])) {
            $match = true;
        } else {
            throw new \Exception("Method not allowed", 405);
        }

        if (!$match) {
            throw new \Exception("Page Not Found", 404);
        }

        return $match;

    }

    /**
     * Execute the controller in the configuration of the matched route
     * @return mixed
     * @throws \Exception
     */
    public function exec()
    {
        $controllerParam = explode(":", $this->matchRoute["controller"]);
        #TODO : denied access with wrong role
        $class = "$controllerParam[0]Controller";

        if (class_exists($class)) {
            $controller = new $class;
            $action = $controllerParam[1];

            if (is_callable([$controller, $action])) {
                $methodParameters = (new DependencyInjection($class, $action))->getParameters($this->matchRoute["params"]);
                return !empty($methodParameters) ? call_user_func_array([$controller, $action], $methodParameters) : $controller->$action();
            } else {
                ConfigHandler::get("eventEmmiter")->emit("error.404", "Action $action not found");
            }
        } else {
            ConfigHandler::get("eventEmmiter")->emit("error.404","Class $class not found");
        }
    }

    /**
     * Récupération du chemin dans la config s'il existe
     * @param string $route
     * @return string|null
     */
    public function getPath(string $route, string $param = null): ?string
    {
        $route = key_exists($route, $this->routes) ? $this->routes[$route]["path"] : null;

        if(is_null($route)) return "";

        $tab = explode("/", $route);

        foreach ($tab as $key => $value){
            if(preg_match("/\{(.*?)\}/m", $value)){
                $tab[$key] = $param;
            }
        }

        return implode("/", $tab);
    }

    /**
     * Get the url and return an useable string
     */
    private function formatUrl(): void
    {
        $requestUri = rtrim($_SERVER["REQUEST_URI"], "/");

        if ($requestUri === "") {
            $this->uri = "/";
        } elseif (strpos("?", $requestUri)) {
            $this->uri = explode("?", $requestUri)[0];
        } else {
            $this->uri = $requestUri;
        }

    }

    /**
     * Test if the url have some paramaters
     *
     * @param  $params
     * @return bool|mixed
     */
    private function hadParams($params): ?bool
    {
        return strpos($params, "{") === false ? false : true;
    }

    /**
     * Test if the current route contain some parameters
     * @param $route
     * @return bool
     * @throws \Exception
     */
    private function matchComplexRoute($route): bool
    {
        $match = false;
        $tabUrl = explode("/", $route["path"]);
        $this->uriArray = explode("/", $this->uri);

        // If the uri don't have the same amount of element, stop
        if (count($this->uriArray) != count($tabUrl)) {
            return $match;
        }

        foreach ($tabUrl as $key => $item) {
            // If the uri the element don't math with the current route, stop
            if (!$this->hadParams($item) && $this->uriArray[$key] !== $item) {
                return $match;
            }
        }

        // Retrieve the parameters url
        $macthes = $this->matchParams($route["path"]);

        // If we retrieve the parameters return the route
        if (!is_null($macthes)) {
            $route["params"] = $macthes;
            $this->matchRoute = $route;
            $match = true;
        }

        return $match;
    }

    /**
     * Create the right regex then exec a regex on the value
     *
     * @param string $str
     * @return mixed
     * @throws \Exception
     */
    private function matchParams(string $str): ?array
    {
        /**
         * Regex to extract the parameters name and is type
         */
        preg_match_all('/{(\w+)<{1}(\\\\\w+\+)>{1}\??}/m', $str, $pregParameters);

        // Retrieve the entire match result
        $params = $this->getParameters($str);

        // Test if the parameters had regex rule and test it
        if (isset($pregParameters[2][0]) && isset($pregParameters[1][0])) {
            $reg = $pregParameters[2][0];
            if (preg_match("/${reg}/", $params)) {
                return [$pregParameters[1][0] => $params];
            } else {
                throw new \Exception("Parameter is not in the correct type");
            }
        }

        return [];
    }


    /**
     * return all parameters in url
     *
     * @param  $path
     * @return |null
     */
    private function getParameters(string $path): ?string
    {
        $tabPath = explode("/", $path);

        $param = null;

        foreach ($tabPath as $key => $data) {
            if ($this->hadParams($data)) {
                $param = $this->uriArray[$key];
            }
        }

        return $param;
    }
}