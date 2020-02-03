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

        if(file_exists($value . ".tpl.php")) {
            $template = file_get_contents($value . ".tpl.php");
        }else{
            ExceptionHandler::defaultRequestHandler();
            exit;
        }

        preg_match_all("#^@section\((\w+)\)$#m", $template, $sections);

        foreach ($sections[1] as $key => $value){
            preg_match("/@section\($value\)([\s\S]+)@endsection/m", $view, $sectionsValue);
            $template = preg_replace("#^@section\($value\)$#m", $sectionsValue[1], $template);
        }

        return $template;
    }

    public static function loop(){}

    public static function getErrorFeedback(array $errors, TemplateEngine $engine){

        $engine->setData(["parameter" => $errors]);
        $errorsInput = $engine->renderHtmlElement("errors");
        dump($errorsInput, "Error input");
        die($engine->getContent());
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