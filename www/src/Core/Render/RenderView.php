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

    private $defaultData = [];

    private $templateEngine;

    public function __construct()
    {
        $this->templateEngine = new TemplateEngine();
        $this->defaultData["session"] = [];//ConfigHandler::get("session");
    }

    public static function include(string $template, array $param = [])
    {
        $defaultData = [
            "session" => ConfigHandler::get("session")->offsetGet("app.user") ? ["connected" => true, "roles" => null] : ["connected" => false, "roles" => null],
            "flash" => ConfigHandler::get("session")->get("app.flash") ?? "",
        ];

        ob_start();

        extract($param, EXTR_OVERWRITE);
        extract($defaultData, EXTR_SKIP);

        $includeEngine = new TemplateEngine();

        if($includeEngine->setView($template)) {
            $includeEngine->setData(["parameter" => $param, "config" => $param]);
            $includeEngine->generate_markup();
            $includeEngine->compile(false);
        }else{
            ExceptionHandler::defaultRequestHandler("View Not Found");
        }

        $ret = ob_get_contents();
        ob_end_clean();

        return $ret;

    }
    /**
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
            ExceptionHandler::defaultRequestHandler("View Not Found");
        }
    }
*/
    public function render(string $template, array $param = [], bool $display = false)
    {

        if($this->templateEngine->setView($template)) {
            $this->templateEngine->setData(["parameter" => $param, "config" => $this->defaultData, "render" => $display]);
            $this->templateEngine->generate_markup();

            ConfigHandler::get("session")->set("app.flash", null);

            if($display){
                dump("Render View");
                return $this->templateEngine->compile($display);
            }

            return $this;
        }

        ExceptionHandler::defaultRequestHandler("View Not Found");
    }

    public function renderHtmlElement(string $type, array $options)
    {
        $options["prefix"] = "app_form";

        $this->templateEngine->setData(["parameter" => $options]);
        $this->templateEngine->setView(FORM_PATH."/input.tpl.php");
        return $this->templateEngine->renderHtmlElement($type);
    }

    public function compile(){
        return $this->templateEngine->compile();
    }
}