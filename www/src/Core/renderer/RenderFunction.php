<?php


namespace App\Core\renderer;


use App\Core\Exceptions\ExceptionHandler;

class RenderFunction
{

    public static function include(string $value, array $data){
        $dir = ROOT_DIR . "/public/views";
        $value = str_replace("@View", $dir, $value);
        return RenderView::include($value, $data);
    }
    public static function extend(string $value, string $view  = ""){
        $dir = ROOT_DIR . "/public/views";
        $value = str_replace("@View", $dir, $value);

        if(file_exists($value . ".view.php")) {
            $template = file_get_contents($value . ".view.php");
        }else{
            ExceptionHandler::defaultRequestHandler();
            exit;
        }

        preg_match_all("#^\s+?@section\((\w+)\)$#m", $template, $sections);

        foreach ($sections[1] as $key => $value){
            preg_match("/^\s+?@section\($value\)([\s\S]+)@endsection$/mU", $view, $sectionsValue);
            $template = preg_replace("#^\s+?@section\($value\)$#m", $sectionsValue[1], $template);
        }

        return $template;
    }
    public static function loop(){}

    public static function getErrorFeedback(array $errors, TemplateEngine $engine){
        if(isset($data["errors"])){
            return "";
        }

        $errorsInput = $engine->renderHtmlElement("error");
        $html = "";

        foreach ($errors as $key => $value){
            $html .= preg_replace("^{{ ?value ?}}$", $value, $errorsInput);
        }

        return $html;
    }
}