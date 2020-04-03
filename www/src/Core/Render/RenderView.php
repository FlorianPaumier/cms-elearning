<?php

namespace App\Core\Render;

use App\Core\Cache\ConfigHandler;
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
        $this->defaultData["session"] = [];//ConfigHandler::get("session");
    }

    /**
     * @param string $template
     * @param array $param
     * @return false|string
     */
//    public static function include(string $template, array $param = [])
//    {
//        $defaultData = [
//            "session" => ConfigHandler::get("session")->offsetGet("app.user") ? ["connected" => true, "roles" => null] : ["connected" => false, "roles" => null],
//            "flash" => ConfigHandler::get("session")->get("app.flash") ?? "",
//        ];
//
//        ob_start();
//
//        extract($param, EXTR_OVERWRITE);
//        extract($defaultData, EXTR_SKIP);
//
//        $includeEngine = new TemplateEngine();
//
//        if($includeEngine->setView($template)) {
//            $includeEngine->setData(["parameter" => $param, "config" => $param]);
//            $includeEngine->generate_markup();
//            $includeEngine->compile(false);
//        }else{
//            ExceptionHandler::defaultRequestHandler("View Not Found");
//        }
//
//        $ret = ob_get_contents();
//        ob_end_clean();
//
//        return $ret;
//
//    }
//

    /**
     * Parse and Include the file
     * @param string $template
     * @param array $args
     * @return string|string[]|null
     * @throws \Exception
     */
    public static function include(string $template, array $args = [])
    {
        $defaultData = [
            "session" => ConfigHandler::get("session")->offsetGet("app.user") ? ["connected" => true, "roles" => null] : ["connected" => false, "roles" => null],
            "flash" => ConfigHandler::get("session")->get("app.flash") ?? "",
        ];

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

            if(ConfigHandler::get("session")){
                ConfigHandler::get("session")->set("app.flash", null);
            }

            if($display){
                return $this->templateEngine->compile($display);
            }

            return $this;
        }

        ConfigHandler::get("eventEmmiter")->emit("error.404");
    }

    /**
     * Create a html element
     * @param string $type
     * @param array $options
     * @return string
     * @throws \Exception
     */
    public function renderHtmlElement(string $type, array $options)
    {
        $options["prefix"] = "app_form";

        $this->templateEngine->setData(["parameter" => $options]);
        if($this->templateEngine->setView(FORM_PATH."/input.tpl.php")){
            return $this->templateEngine->renderHtmlElement($type);
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
}