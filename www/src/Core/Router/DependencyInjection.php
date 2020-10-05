<?php


namespace App\Core\Router;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\EntityManager;
use App\Core\Database\Repository\AbstractRepository;
use App\Core\Exceptions\NotFoundAbsctractException;
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
                        if (is_null($parameter->getClass())) {
                            array_splice($parameters, $parameter->getPosition(), 0, [$args[$name]]);
                            continue;
                        }

                        $className = $parameter->getClass()->getName();
                        $class = new $className();

                        if (!empty($args)) {
                            /** @var AbstractRepository $repo */
                            $repo = ConfigHandler::get("entityManager")->getRepository($className . "Repository");

                            if (!is_null($repo)) {
                                $class = $repo->findOneBy($args);
                            }

                            if(is_null($class)){
                                ConfigHandler::get("eventEmmiter")->emit("error.404","Cette page n'existe pas. Veuillez revenir à la page précédente");
                            }
                        }
                        array_splice($parameters, $parameter->getPosition(), 0, [$name => $class]);
                    } catch (\Exception $e) {
                        dump($e->getMessage(), "Error");
                    }
                }
            }
        } catch (\Exception $e) {
            dump($e->getMessage(), "Error");
            die;
        }

        return $parameters;
    }
}
