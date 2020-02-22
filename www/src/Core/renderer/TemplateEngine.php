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
    private $extendMethod;

    private $extandEntries = null;

    private $blockEntries;

    private $functions = [];

    private $viewParser;

    private $cacheDir;

    /** @var bool */
    private $rendering;

    public function __construct()
    {
        $this->viewParser = new ParseView();
        $this->cacheDir = dirname(__DIR__, 3) . "/app/cache/views/";
    }

    public function setFormTemplateFile(string $templateFile)
    {
        $this->templateContent = $templateFile;
    }

    public function getTemplateFile()
    {
        return $this->templateFile;
    }

    public function getContent(){
        return $this->templateContent;
    }

    public function setTemplateFile(string $templateFile)
    {
        foreach (self::TPL_EXT as $ext) {
            if (file_exists(DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $templateFile . $ext)) {
                $this->templateFile = DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $templateFile . $ext;
            } elseif (file_exists($templateFile . $ext)) {
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
        if (!file_exists($this->cacheDir . md5($this->templateFile) . ".php")) {
            $this->_load_template();
            $this->_extendFile();
        } else {
            $this->templateContent = file_get_contents($this->cacheDir . md5($this->templateFile) . ".php");
        }
    }

    private function _load_template()
    {
        if (file_exists($this->templateFile) && is_readable($this->templateFile)) {
            $this->templateContent = file_get_contents($this->templateFile);
        }
    }

    private function _parseTemplate()
    {
        preg_match_all("/{{\s?(\w+)\s?}}/m", $this->templateContent, $this->fieldEntries, PREG_SET_ORDER, 0);
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
        if($type == "errors"){
            dump($this->templateContent, "Template Content");
        }
        preg_match_all("/.*{%\s?block\s${type}\s?%}((?s:.+?)){%\s?endblock\s?%}.*/m", $this->templateContent, $this->blockEntries, PREG_SET_ORDER, 0);

        if($type == "errors"){
            dump($this->blockEntries, "Block Entries");
        }

        $this->templateContent = $this->blockEntries[0][1] ?? "";
        $debug = $type == "errors" ? true : false;
        $this->_compileForm($debug);
        return $this->templateContent;
    }

    public function compile(bool $tags = true)
    {
        $this->_parseTemplate();

        if (count($this->methodEntries) > 0) {
            $this->_parseFunctions();
        }

        foreach ($this->functions as $regex => $html) {
            $this->templateContent = preg_replace("/$regex/", $html, $this->templateContent);
        }

        if ($tags) {

            $temp = tmpfile();
            fwrite($temp, $this
                ->templateContent);
            $cacheFile = md5($this->templateFile) . ".php";

            if($_SERVER["APP_ENV"] != 'dev'){
                copy(stream_get_meta_data($temp)['uri'], $this->cacheDir . $cacheFile);
            }

            if (count($this->fieldEntries) > 0) {
                $this->_parseTags();
                $this->_parseTemplate();

                if (count($this->methodEntries) > 0) {
                    $this->_parseFunctions($this);
                }
            }
        }

        if(isset($this->data["render"]) && $this->data["render"]){
            return $this->templateContent;
        }

        $tmp = tmpfile();
        fwrite($tmp, $this->templateContent);
        include stream_get_meta_data($tmp)['uri'];

    }

    private function _extendFile()
    {
        preg_match_all("/{{ (@?[\w+\/?]+)\|(extend) }}/m", $this->templateContent, $this->extendMethod, PREG_SET_ORDER, 0);

        if (is_null($this->extendMethod)) {
            return "";
        }

        foreach ($this->extendMethod as $tag) {
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

    private function _parseFunctions(TemplateEngine $engine = null)
    {
        $this->functions = $this->viewParser->parseFunction($this->data, $this->methodEntries, $engine);
    }

    private function _parseTags()
    {
        $this->templateContent = $this->viewParser->parseTags($this->templateContent, $this->data, $this->fieldEntries);
    }

    private function _compileForm(bool $debug = false)
    {
        $this->_parseTemplate();
        $this->_parseTags();
    }
}