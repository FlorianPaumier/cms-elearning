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

    /**
     * @var string
     */
    private $templateContent;

    /**
     * @var string
     */
    private $extendsContent;

    /**
     * @var array
     */
    private $data;

    /**
     * @var array
     */
    private $fieldEntries;

    /**
     * @var array
     */
    private $methodEntries;

    /**
     * @var array
     */
    private $extendMethod;

    private $extandEntries = null;

    /**
     * @var array
     */
    private $blockEntries;

    /**
     * @var array
     */
    private $functions = [];

    /**
     * @var ParseView
     */
    private $viewParser;

    /**
     * @var string
     */
    private $cacheDir;

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

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function generate_markup($extra = []): void
    {
        // Try to get the skeleton in the cache or create it
        if (!file_exists($this->cacheDir . md5($this->templateFile) . ".php")) {
            // Get the content of the view
            $this->_load_template();
            // Try to include an extending view
            $this->_extendFile();
        } else {
            // Get the content of the view in the cache
            $this->templateContent = file_get_contents($this->cacheDir . md5($this->templateFile) . ".php");
        }
    }

    /**
     * Render the html element to create a form
     *
     * @param string $type
     * @return string
     */
    public function renderHtmlElement(string $type): void
    {
        /**
         * Get all the content between block and endblock
         */
        preg_match_all("/.*{%\ block ${type} %}((?s:.+?)){%\ endblock.*?%}.*/m", $this->templateContent, $this->blockEntries, PREG_SET_ORDER, 0);
        $this->templateContent = $this->blockEntries[0][1] ?? "";
        $this->_parseTemplate();
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
            fwrite($temp, $this->templateContent);
            $cacheFile = md5($this->templateFile) . ".php";
            copy(stream_get_meta_data($temp)['uri'], $this->cacheDir . $cacheFile);

            if (count($this->fieldEntries) > 0) {
                $this->_parseTags();
            }
        }
        $tmp = tmpfile();
        fwrite($tmp, $this->templateContent);
        include stream_get_meta_data($tmp)['uri'];

    }


    /**
     * Test to retrieve the view file
     */
    private function _load_template(): void
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
     * @return string
     */
    private function _extendFile()
    {
        // Get the path to the view to extend
        preg_match_all("/{{ (@?[\w+\/?]+)\|(extend) }}/m", $this->templateContent, $this->extendMethod, PREG_SET_ORDER, 0);

        if (is_null($this->extendMethod)) {
            return "";
        }

        foreach ($this->extendMethod as $tag) {
            $template = $tag[2];
            $value = $tag[1];
            $html = null;
            // Todo transform to a simple if
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