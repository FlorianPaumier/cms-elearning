<?php


namespace App\Core\Render;


use App\Core\Cache\ConfigHandler;
use App\Core\Kernel\Kernel;

class ParseView
{

    /**
     * Replace the tags in template by the value
     * @param string $content
     * @param array $data
     * @param array $fieldEntries
     * @return string|string[]|null
     */
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

    /**
     * Replace the function tags by the result of the function
     * @param array $data
     * @param array $methodEntries
     * @param TemplateEngine|null $engine
     * @return array
     */
    public function parseFunction(array $data, array $methodEntries, TemplateEngine $engine = null){
        $functions = [];
        foreach ($methodEntries as $tag) {
            $template = $tag[1];
            $value = $tag[2];
            $html = null;

            switch ($template) {
                case "path":
                    $html = ConfigHandler::get("router")->getPath($value);
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
            }

            if (!is_null($html)) {
                $regex = addcslashes($tag[0], "/|()");
                $functions[$regex] = $html;
            }
        }

        return $functions;
    }
}