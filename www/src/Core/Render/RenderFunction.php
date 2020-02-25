<?php


namespace App\Core\Render;


use App\Core\Exceptions\ExceptionHandler;

class RenderFunction
{

    public static function include(string $value, array $data){

        $content = RenderView::include(VIEW_PATH."/$value", $data);
        return $content;
    }
    public static function extend(string $value, string $view = ""){
        if(file_exists(VIEW_PATH."/$value.tpl.php")) {
            $template = file_get_contents(VIEW_PATH."/$value.tpl.php");
        }else{
            throw new \Exception("Page not found", 404);
        }

        preg_match_all("#^\s*?@section\((\w+)\)$#m", $template, $sections);

        foreach ($sections[1] as $key => $value){
            preg_match("#^\s*?@section\($value\)([\s\S]*)@endsection$#mU", $view, $sectionsValue);
            $template = preg_replace("#^\s*?@section\($value\)$#m", $sectionsValue[1], $template);
        }

        return $template;
    }

    public static function loop(){}

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