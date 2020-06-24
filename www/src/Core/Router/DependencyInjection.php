<?php


namespace App\Core\Router;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\EntityManager;
use App\Core\Kernel\Kernel;

class DependencyInjection
{

    private $controller;
    private $action;

    public function __construct(string $controller, string $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    public function getParameters(?array $args)
    {
        if (is_null($args)) {
            $args = [];
        }

        $parameters = [];

        try {
            $functionParams = new \ReflectionMethod($this->controller, $this->action);
            foreach ($functionParams->getParameters() as $parameter) {
                $name = $parameter->getName();


                if (!is_null($var = ConfigHandler::get($parameter->getName()))) {
                    array_splice($parameters, $parameter->getPosition(), 0, [$var]);
                } else {
                    try {
                        if(is_null($parameter->getClass())){
                            array_splice($parameters, $parameter->getPosition(), 0, [$args[$name]]);
                            continue;
                        }

                        $className = $parameter->getClass()->getName();
                        $class = new $className();

                        if (!empty($args)) {
                            /** @var EntityManager $repo */
                            $repo = ConfigHandler::get("entityManager");
                            $repo->getClass($className);
                            $class = $repo->setEntity($className)->findBy($args);
                        }
                        array_splice($parameters, $parameter->getPosition(), 0, [$name => $class]);
                    } catch (\Exception $e) {
                        dump($e->getMessage(), "Error");
                    }
                };
            }
        } catch (\Exception $e) {
            dump($e->getMessage(), "Error");
            die;
        }

        return $parameters;
    }
}