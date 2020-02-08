<?php

namespace App\Core\Router;

use App\Core\Exceptions\ExceptionHandler;
use App\Core\Kernel\Kernel;
use App\Core\request\RedirectionHandler;
use App\Core\Request\Request;

class Router
{
    /**
     * @var array
     */
    private $routingConfig;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var RedirectionHandler
     */
    private $redirect;

    /**
     * @var string
     * Request Uri
     */
    private $uri;

    /**
     * @var array
     * Exploded Uri by /
     */
    private $tabUri;

    /**
     * Get the configuration data and init the redirection Object
     * Router constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->routingConfig = Kernel::get('routing');
        $this->request = Kernel::get("request");
        $this->redirect = new RedirectionHandler();
    }

    /**
     * Look into the routing configuration if the uri match with an entry
     *
     * @return false|mixed|string
     * @throws \Exception
     */
    public function isMatch(): void
    {

        // Transform the url
        $this->formatRoute();

        $match = null;
        $params = [];

        // Walk into the route array and filter them
        foreach ($this->routingConfig as $route) {
            $match = $this->getRoute($route);
            // If route is find stop the  loop
            if (!is_null($match)) {
                break;
            }
        }

        //If nothing match throw new exception
        if (!is_null($match)) {
            //If method don't match throw new exception
            if (!isset($match["method"]) || in_array($this->request->getMethod(), $match["method"])) {

                //If we have found params send it
                if (!is_null($match)) {
                    $params = key_exists("params", $match) ? $match["params"] : [];
                }

                // Execute the processus from the route found
                $this->exec($match, $params);
            };
            ExceptionHandler::invalidMethodHandler($this->request);
        }
        ExceptionHandler::defaultRequestHandler("La route ne correspond pas");
    }

    /**
     * Removes trailing forward slashes from the right of the route.
     */
    private function formatRoute(): void
    {
        // Retrive the uri and remove the right /
        $result = rtrim($this->request->getServer()["REQUEST_URI"], '/');

        if ($result === '') {
            $this->uri = '/';
        } elseif (strpos($result, "?") !== false) {
            // Retrive the left part of the uri
            $this->uri = explode("?", $result)[0];
        } else {
            $this->uri = $result;
        }

        // Set the element of the uri into an array
        $this->tabUri = explode("/", $this->uri);
    }

    /**
     * Try to match a simple route without parameters
     *
     * @param  $route
     * @return null
     * @throws \Exception
     */
    private function getRoute($route): ?array
    {
        // If the key don't exist throw 404
        if (!key_exists("path", $route)) {
            throw new \Exception();
        }

        // Test if it's simple road or had some parameters
        if ($this->hadParams($route["path"])) {
            return $this->getComplexRoute($route);
        } else {
            return $this->uri === $route["path"] ? $route : null;
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
     * Try to match a simple route with parameters
     *
     * @param  $route
     * @return null
     */
    private function getComplexRoute($route): ?array
    {
        $routeValue = null;

        $tabUrl = explode("/", $route["path"]);

        // If the uri don't have the same amount of element, stop
        if (count($this->tabUri) != count($tabUrl)) {
            return null;
        }

        foreach ($tabUrl as $key => $item) {
            // If the uri the element don't math with the current route, stop
            if (!$this->hadParams($item) && $this->tabUri[$key] !== $item) {
                return null;
            }
        }

        // Retrieve the parameters url
        $macthes = $this->matchParams($route["path"]);

        // If we retrieve the parameters return the route
        if (!is_null($macthes)) {
            $route["params"] = $macthes;
            return $route;
        }

        return null;
    }

    /**
     * Create the right regex then exec a regex on the value
     *
     * @param  $str
     * @return mixed
     */
    private function matchParams($str): ?array
    {
        /**
         * Regex to extract the parameters name and is type
         */
        preg_match_all('/{(\w+)<{1}(\\\\\w+\+)>{1}\??}/m', $str, $pregParameters);

        // Retrieve the entire match result
        $params = $this->getParams($str);

        // Test if the parameters had regex rule and test it
        if (isset($pregParameters[2][0]) && isset($pregParameters[1][0])) {
            $reg = $pregParameters[2][0];
            return preg_match("/${reg}/", $params) ? [$pregParameters[1][0] => $params] : null;
        }

        return [];
    }

    /**
     * return all parameters in url
     *
     * @param  $path
     * @return |null
     */
    private function getParams($path): ?string
    {
        $tabPath = explode("/", $path);
        $tabUri = explode("/", $this->uri);

        $param = null;

        foreach ($tabPath as $key => $data) {
            if ($this->hadParams($data)) {
                $param = $tabUri[$key];
            }
        }

        return $param;
    }

    /**
     * Call the controller refer to the route in the configuration
     *
     * @param  $route
     * @param  array $parameters
     * @return false|mixed|string
     * @throws \Exception
     */
    public function exec($route, array $parameters = []): void
    {

        // Get the user manager to test if the user is allowed to use the current route
        // And redirect if not
        $userManager = kernel::get("userManager");

        if (!$userManager->isAllowed($route)) {
            $this->redirect
                ->redirectToRoute("app_user_login");
        }

        //Get the different part of the controller row
        $controllerData = $this->getController($route);
        $controller = new $controllerData["name"]();
        $action = $controllerData["action"];

        // Test if the callable give exist
        if (is_callable([$controller, $action])) {
            //TODO : Remettre en place la injection de dépendance
            //$methodParameters = (new DependencyInjection($controllerData["name"], $action))->getParameters($parameters);
            $methodParameters = $parameters;

            //Call the action with the params if needed
            !empty($methodParameters) ? call_user_func_array([$controller, $action], $methodParameters) : $controller->$action();
        }

        ExceptionHandler::defaultRequestHandler("Pas de fonction trouvé au nom de ' ${action} ' dans le controller ' src/${controllerData['path']} '");
    }

    /**
     * Get the name and the action from the route entry
     *
     * @param  $route
     * @return array
     */
    private function getController($route): array
    {
        // Extract and transform the information from the route configuration
        $controller = explode(":", $route["controller"]);
        $data = ["path" => $controller[0]];
        $controllerTab = explode("/", $data["path"]);
        $data["name"] = array_pop($controllerTab) . "Controller";
        $data["action"] = $controller[1];

        return $data;
    }

    /**
     * Return the path for the view
     *
     * @param  string $name
     * @return |null
     */
    public function getPath(string $name): ?string
    {
        return key_exists($name, $this->routingConfig) ? $this->routingConfig[$name]["path"] : null;
    }
}
