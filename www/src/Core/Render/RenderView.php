<?php

namespace App\Core\Render;

use App\Core\Cache\ConfigHandler;
use App\Core\Exceptions\AbsctractException;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Kernel\Kernel;
use App\Core\Session\PHPSession;

class RenderView
{
    /**
     * @var PHPSession
     */
    private $session;

    /** @var array */
    private $defaultData = [];

    /** @var TemplateEngine  */
    private $templateEngine;

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->defaultData["session"] = ConfigHandler::get("session")->getSession();
    }


    /**
     * Parse and Include the file
     * @param string $template
     * @param array $args
     * @return string|string[]|null
     * @throws \Exception
     */
    public static function include(string $template, array $args = [])
    {
        $defaultData = [];
//            "session" => ConfigHandler::get("session")->offsetGet("app.user") ? ["connected" => true, "roles" => null] : ["connected" => false, "roles" => null],
//            "flash" => ConfigHandler::get("session")->get("app.flash") ?? "",
//        ];

        $includeEngine = new TemplateEngine();

        array_merge($args, $defaultData);

        $args["render"] = true;

        if($includeEngine->setView($template)){
            $includeEngine->setData($args);
            $includeEngine->generate_markup();
            return $includeEngine->compile(false);
        }else{
            ConfigHandler::get("eventEmmiter")->emit("error.404","View Not Found");
        }
    }

    /**
     * Parse the content and create the skeleton
     * @param string $template
     * @param array $param
     * @param bool $display
     * @return $this|string|string[]|null
     * @throws \Exception
     */
    public function render(string $template, array $param = [], bool $display = false)
    {
        if($this->templateEngine->setView($template)) {
            $this->templateEngine->setData(["parameter" => $param, "config" => $this->defaultData, "render" => $display]);
            $this->templateEngine->generate_markup();

            if($display){
                if(ConfigHandler::get("session")){
                    ConfigHandler::get("session")->offsetSet("app.flash", null);
                }
                return $this->templateEngine->compile($display);
            }

            return $this;
        }

        ConfigHandler::get("eventEmmiter")->emit("error.404", "The view $template doesn't exist");
    }

    /**
     * Create a html element
     * @param mixed $type
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function renderHtmlElement($type, array $options)
    {
        if(!gettype($type) == "object"){
            if(class_exists($type)){
                $type = new $type;
            }
        }

        $view = gettype($type) == "object" ? $type::getTemplate() : FORM_PATH."/input.tpl.php";
        $options["prefix"] = "app_form";


        $this->templateEngine->setData(["parameter" => $options]);
        if($this->templateEngine->setView($view)){
            $html = $this->templateEngine->renderHtmlElement($type);
            return $html;
        };

        ConfigHandler::get("eventEmmiter")->emit("error.404","View Not Found");
    }

    /**
     * Compile the data and the view
     * @return string|string[]|null
     * @throws \Exception
     */
    public function compile(){
        return $this->templateEngine->compile();
    }

    public function renderErrors(string $view,\Exception $exception)
    {
        if($_SERVER["APP_ENV"] == "dev"){
            echo $this->render($view, [
                "message" => $exception->getMessage(),
                "line" => $exception->getLine(),
                "trace" => $exception->getTrace(),
                "code" => $exception->getCode(),
            ])->compile();
        }
    }
}