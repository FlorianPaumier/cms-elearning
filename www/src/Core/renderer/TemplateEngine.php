<?php


namespace App\Core\Renderer;


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

    private $functions = [];

    private $viewParser;

    public function __construct()
    {
        $this->viewParser = new ParseView();
    }

    public function setFormTemplateFile(string $templateFile)
    {
        $this->templateContent = $templateFile;
    }

    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    public function setTemplateFile(string $templateFile)
    {
        foreach (self::TPL_EXT as $ext) {
            if (file_exists(DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $templateFile . $ext)) {
                $this->templateFile = DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $templateFile . $ext;
            }elseif(file_exists($templateFile . $ext)){
                $this->templateFile = $templateFile . $ext;
            }
        }
    }

    public function setData(array $data = [])
    {
        $this->data = $data;
    }

    public function generate_markup($extra = [])
    {
        $this->_load_template();
        $this->_extendFile();
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

    /**
     * Render the html element to create a form
     *
     * @param string $type
     * @return string
     */
    public function renderHtmlElement(string $type)
    {
        preg_match_all("/.*{%\ block ${type} %}((?s:.+?)){%\ endblock.*?%}.*/m", $this->templateContent, $this->blockEntries, PREG_SET_ORDER, 0);
        $this->templateContent = $this->blockEntries[0][1] ?? "";
        $this->_parseTemplate();
    }

    public function compile(bool $tags = true)
    {
        $this->_parseTemplate();
        $this->_parseFunctions();

        foreach ($this->functions as $regex => $html) {
            $this->templateContent = preg_replace("/$regex/", $html, $this->templateContent);
        }

        #TODO : Caching the skeleton
        if($tags){
            $this->_parseTags();
        }

        $temp = tmpfile();
        fwrite($temp, $this->templateContent);
        include stream_get_meta_data($temp)['uri'];
    }

    private function _extendFile()
    {
        preg_match_all("/{{ (@?[\w+\/?]+)\|(extend) }}/m", $this->templateContent, $this->methodEntries, PREG_SET_ORDER, 0);

        if(is_null($this->methodEntries))
            return "";

        foreach ($this->methodEntries as $tag) {
            $template = $tag[2];
            $value = $tag[1];
            $html = null;

            switch ($template) {
                case "extend":
                    $this->templateContent = RenderFunction::extend($value, $this->templateContent);
                    break;
            }


        }
    }

    private function _parseFunctions()
    {
        $this->functions = $this->viewParser->parseFunction($this->data, $this->methodEntries);
    }

    private function _parseTags()
    {
        $this->templateContent = $this->viewParser->parseTags($this->templateContent, $this->data, $this->fieldEntries);
    }
}