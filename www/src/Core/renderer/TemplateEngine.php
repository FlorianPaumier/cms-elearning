<?php


namespace App\Core\Renderer;


use App\Core\Exceptions\ExceptionHandler;
use App\Core\Kernel\Kernel;

class TemplateEngine
{
    private const TPL_EXT = [
        ".view.php",
        ".tpl.php",
    ];

    /**
     * @var string
     */
    private $templateFile;

    private $templateContent;

    private $extendsContent;

    /**
     * @var array
     */
    private $data;

    private $fieldEntries;

    private $methodEntries;

    private $extandEntries = null;

    private $blockEntries;

    public function setTemplateFile(string $templateFile)
    {
        foreach (self::TPL_EXT as $ext){
            if(file_exists(DEFAULT_VIEW_DIR.DIRECTORY_SEPARATOR.$templateFile.$ext)){
                $this->templateFile = DEFAULT_VIEW_DIR.DIRECTORY_SEPARATOR.$templateFile.$ext;
            }
        }
    }

    public function setFormTemplateFile(string $templateFile)
    {
        $this->templateContent = $templateFile;
    }

    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    public function setData(array $data = [])
    {
        $this->data = $data;
    }

    public function generate_markup($extra = [])
    {
        $this->_load_template();
        $this->_parseTemplate();
        $this->_replaceTags();
        $this->_replaceFunctions();

        return !$this->_replaceBlocks() ? $this->templateContent : $this->extendsContent;
    }

    /**
     * Render the html element to create a form
     * @param string $type
     * @return string
     */
    public function renderHtmlElement(string $type)
    {
        preg_match_all("/.*{%\ block ${type} %}((?s:.+?)){%\ endblock.*?%}.*/m", $this->templateContent, $this->blockEntries, PREG_SET_ORDER, 0);
        $this->templateContent = $this->blockEntries[0][1] ?? "";

        $this->_parseTemplate();
        $this->_replaceFunctions();
        $this->_replaceTags();
        return $this->templateContent;
    }

    private function _load_template()
    {
        if (file_exists($this->templateFile) && is_readable($this->templateFile)) {
            $this->templateContent = file_get_contents($this->templateFile);
        }
    }

    private function _parseTemplate()
    {
        preg_match_all("/{{(\w+)}}/m", $this->templateContent, $this->fieldEntries, PREG_SET_ORDER, 0);
        preg_match_all("/{{ (@?[\w+\/?]+)\|(\w+) }}/m", $this->templateContent, $this->methodEntries, PREG_SET_ORDER, 0);
    }

    private function _replaceTags()
    {
        foreach ($this->data["parameter"] as $key => $value) {
            foreach ($this->fieldEntries as $tag) {
                if ($tag[1] == $key) {
                    $this->templateContent = preg_replace("/{{($key)}}/", $value, $this->templateContent);
                }
            }
        }
    }

    private function _replaceFunctions()
    {
        foreach ($this->methodEntries as $tag) {
            $template = $tag[2];
            $value = $tag[1];
            $html = null;

            switch ($template) {
                case "include":
                case "require":
                    $dir = ROOT_DIR . "/public/views";
                    $value = str_replace("@View", $dir, $value);
                    $html = RenderView::include($value, $this->data);
                    break;
                case "path":
                    $html = Kernel::get("router")->getPath($value);
                    break;
                case "isRequired":
                    $html = isset($this->data["required"]) ? 'required="required"' : "";
                    break;
                case "isMultiple":
                    $html = isset($this->data["multiple"]) ? 'multiple' : "";
                    break;
                case "isSelected":
                    $html = isset($this->data["selected"]) ? 'selected' : "";
                    break;
                case "errorFeedback":
                    $html = isset($this->data["errors"]) ? " " : "";
                    break;
                default:
                    if (function_exists("include")) {
                        $html = $template($value);
                    }
                    break;
            }

            if (!is_null($html)) {
                $regex = addcslashes($tag[0], "/|");
                $this->templateContent = preg_replace("/$regex/", $html, $this->templateContent);
            }
        }
    }

    private function _replaceBlocks(){
        preg_match_all("/.*{%\ block.*?%}((?s:.+?)){%\ endblock.*?%}.*/m", $this->templateContent, $this->blockEntries, PREG_SET_ORDER, 0);

        if(!is_null($this->extandEntries) && count($this->extandEntries) > 0){
            $fileName = trim($this->extandEntries[0][1]).".view.php";
            if(file_exists(DEFAULT_VIEW_DIR."/".$fileName)){
                $this->extendsContent = file_get_contents(DEFAULT_VIEW_DIR."/".$fileName);
                $this->extendsContent = preg_replace("/.*{%\ block.*?%}(?s:.+?){%\ endblock.*?%}.*/m", $this->blockEntries[0][1], $this->templateContent);
                return true;
            }
        };

        return false;
    }

    //TODO: Write a public method to output the result of the templating engine

    //TODO: Write a private method to load the template

    //TODO: Write a private method to parse the template

    //TODO: Write a static method to replace the template tags with entry data

    //TODO: Write a private currying function to facilitate tag replacement

}