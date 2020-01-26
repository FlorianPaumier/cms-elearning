<?php

namespace App\Core\Renderer;

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
        $this->defaultData["session"] = [];//Kernel::get("session");
    }

    public static function include(string $template, array $param = [])
    {
        $defaultData = [
            "session" => Kernel::get("session")->offsetGet("app.user") ? ["connected" => true, "roles" => null] : ["connected" => false, "roles" => null],
            "flash" => Kernel::get("session")->get("app.flash") ?? "",
        ];

        ob_start();

        extract($param, EXTR_OVERWRITE);
        extract($defaultData, EXTR_SKIP);

        $includeEngine = new TemplateEngine();
        $includeEngine->setTemplateFile($template);

        if(!is_null($includeEngine->getTemplateFile())) {
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

    public function render(string $template, array $param = [])
    {
        $this->templateEngine->setTemplateFile($template);

        if(!is_null($this->templateEngine->getTemplateFile())) {
            $this->templateEngine->setData(["parameter" => $param, "config" => $this->defaultData]);
            $this->templateEngine->generate_markup();

            Kernel::get("session")->set("app.flash", null);
            return;
        }

        ExceptionHandler::defaultRequestHandler("View Not Found");
        return;
    }

    public function getHtmlElement(string $type, array $options)
    {
        $elements = file_get_contents(dirname(__DIR__)."/form/form.tpl.php");

        $options["prefix"] = "app_form";

        $this->templateEngine->setData(["parameter" => $options]);
        $this->templateEngine->setFormTemplateFile($elements);
        return $this->templateEngine->renderHtmlElement($type);
    }

    public function compile(){
        $this->templateEngine->compile();
    }
}