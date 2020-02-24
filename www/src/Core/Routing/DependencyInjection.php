<?php


namespace App\Core\Routing;


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

    public function getParameters(array $parameters)
    {

        try {
            $functionParams = new \ReflectionMethod($this->controller, $this->action);

            foreach ($functionParams->getParameters() as $parameter) {
                $name = $parameter->getName();

                if (($var = Kernel::get($parameter->getName(), true)) !== false) {
                    array_splice($parameters, $parameter->getPosition(), 0, [$var]);
                } else {
                    try {
                        $className = $parameter->getClass()->getName();
                        $class = new $className();
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