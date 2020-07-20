<?php


namespace App\Core\renderer;


use App\Core\Kernel\Kernel;

class ParseView
{
    
    public function parseTags(string $content, array $data, array $fieldEntries){
        foreach ($data["parameter"] as $key => $value) {
            foreach ($fieldEntries as $tag) {
                if ($tag[1] == $key) {
                    $content = preg_replace("/{{\s?($key)\s?}}/", $value, $content);
                }
            }
        }
        
        return $content;
    }

    public function parseFunction(array $data, array $methodEntries, TemplateEngine $engine = null){
        $functions = [];
        foreach ($methodEntries as $tag) {
            $template = $tag[2];
            $value = $tag[1];
            $html = null;

            switch ($template) {
                case "include":
                case "require":
                    $html = RenderFunction::include($value, $data);
                    break;
                case "path":
                    $html = Kernel::get("router")->getPath($value);
                    break;
                case "isRequired":
                    $html = isset($data["required"]) ? 'required="required"' : "";
                    break;
                case "isMultiple":
                    $html = isset($data["multiple"]) ? 'multiple' : "";
                    break;
                case "isSelected":
                    $html = isset($data["selected"]) ? 'selected' : "";
                    break;
                case "errorFeedback":
                    $html = RenderFunction::getErrorFeedback($data["errors"] ?? [], $engine);
                    break;
                default:
                    if (function_exists("include")) {
                        $html = RenderFunction::include($value, $data);
                    }
                    break;
            }

            if (!is_null($html)) {
                $regex = addcslashes($tag[0], "/|");
                $functions[$regex] = $html;
            }
        }
        
        return $functions;
    }
}