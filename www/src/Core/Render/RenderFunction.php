<?php


namespace App\Core\Render;

use App\Core\Cache\ConfigHandler;

/**
 * Class RenderFunction
 * @package App\Core\Render
 */
abstract class RenderFunction
{
    /**
     * @param string $value
     * @param array $data
     * @return string|string[]|null
     * @throws \Exception
     */
    public static function include(string $value, array $data){
        return RenderView::include(VIEW_PATH."/$value", $data);
    }

    /**
     * @param string $value
     * @param string $view
     * @return false|string|string[]|null
     * @throws \Exception
     */
    public static function extend(string $value, string $view = ""){
        if(file_exists(VIEW_PATH."/$value.tpl.php")) {
            $template = file_get_contents(VIEW_PATH."/$value.tpl.php");
        }else{
            ConfigHandler::get("eventEmmiter")->emit("error.404", "Page not found");
        }

        preg_match_all("#@section\(([^)]*)\)#m", $template, $sections);

        foreach ($sections[1] as $key => $value){
            preg_match("#^\s*?@section\($value\)([\s\S]*)@endsection#mU", $view, $sectionsValue);
           // dump($sectionsValue);
            $template = preg_replace("#@section\($value\)#mU", $sectionsValue[1], $template);
        }

        return $template;
    }

    /**
     *
     */
    public static function loop(){}

    /**
     * @param array $errors
     * @param TemplateEngine $engine
     * @return string|string[]|null
     */
    public static function getErrorFeedback(array $errors, TemplateEngine $engine){

        $engine->setData(["parameter" => $errors]);
        $errorsInput = $engine->renderHtmlElement("errors");
        $html = "";

        if(empty($errors)){
            return preg_replace("/^{{\s?error\s?}}/", "", $errorsInput);;
        }

        foreach ($errors as $key => $value){
            $html .= preg_replace("/^{{\s?error\s?}}/", $value, $errorsInput);
        }

        return $html;
    }
}