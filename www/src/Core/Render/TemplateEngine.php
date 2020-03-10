<?php


namespace App\Core\Render;


use App\Core\Cache\CacheHandler;

class TemplateEngine
{
    private const TPL_EXT = [
        ".view.php",
        ".tpl.php",
    ];

    /**
     * @var string
     */
    private $view;

    private $content;

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
        $this->cacheDir = CACHE_PATH."/views/";
    }

    public function setView(string $view)
    {
        foreach (self::TPL_EXT as $ext) {
            if (file_exists(DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $view . $ext)) {
                $this->view = DEFAULT_VIEW_DIR . DIRECTORY_SEPARATOR . $view . $ext;
            } elseif (file_exists($view . $ext)) {
                $this->view = $view . $ext;
            }elseif (file_exists(FORM_PATH. "/$view$ext")) {
                $this->view = $view . $ext;
            }elseif (file_exists($view)) {
                $this->view = $view;
                break;
            }
        }

        if(empty($this->view)){
            throw new \Exception("View $view not found");
        }else{
            return true;
        }
    }

    public function setData(array $data = [])
    {
        $this->data = $data;
    }

    public function generate_markup($extra = [])
    {
        if (!CacheHandler::exist($this->view)) {
            $this->_load_template();
            $this->_extendFile();
            $this->_includedFile();
        } else {
            $this->content = CacheHandler::get($this->view);
        }
    }

    private function _load_template()
    {
        if (file_exists($this->view) && is_readable($this->view)) {
            $this->content = file_get_contents($this->view);
        }
    }

    private function _parseTemplate()
    {
        preg_match_all("/{{\s?(\w+)\s?}}/m", $this->content, $this->fieldEntries, PREG_SET_ORDER, 0);
        preg_match_all("/@(\w+)\((.*?)\)/m", $this->content, $this->methodEntries, PREG_SET_ORDER, 0);
    }

    /**
     * Render the html element to create a form
     *
     * @param string $type
     * @return string
     */
    public function renderHtmlElement(string $type)
    {
        $this->_load_template();

        if($type == "errors"){
            dump($this->content, "Template Content");
        }
        preg_match_all("/.*{%\s?block\s${type}\s?%}((?s:.+?)){%\s?endblock\s?%}.*/m", $this->content, $this->blockEntries, PREG_SET_ORDER, 0);

        if($type == "errors"){
            dump($this->blockEntries, "Block Entries");
        }

        $this->content = $this->blockEntries[0][1] ?? "";
        $debug = $type == "errors" ? true : false;
        $this->_compileForm($debug);
        return $this->content;
    }

    public function compile(bool $tags = true)
    {
        $this->_parseTemplate();

        if (count($this->methodEntries) > 0) {
            $this->_parseFunctions();
        }

        if ($tags) {
            CacheHandler::set($this->view, $this->content);

            if (count($this->fieldEntries) > 0) {
                $this->_parseTags();
                $this->_parseTemplate();

                if (count($this->methodEntries) > 0) {
                    $this->_parseFunctions($this);
                }
            }

            foreach ($this->functions as $regex => $function){
                $this->content = preg_replace("#$regex#", $function, $this->content);
            }
        }

        if(isset($this->data["render"]) && $this->data["render"]){
            return $this->content;
        }


        if (!is_null($this->view)) {
            $tmp = tmpfile();
            fwrite($tmp, $this->content);
            extract($this->data["parameter"]);
            include stream_get_meta_data($tmp)['uri'];
        }
    }

    private function _extendFile()
    {
        // Get the path to the view to extend
        preg_match_all("#^@extend\(([\w+\/?]+)\)$#m", $this->content, $this->extendMethod, PREG_SET_ORDER, 0);

        if (is_null($this->extendMethod)) {
            return "";
        }

        foreach ($this->extendMethod as $tag) {
            $value = $tag[1];
            $html = null;
            $this->content = RenderFunction::extend($value, $this->content);
        }
    }

    private function _parseFunctions(TemplateEngine $engine = null)
    {
        $this->functions = $this->viewParser->parseFunction($this->data, $this->methodEntries, $engine);
    }

    private function _parseTags()
    {
        $this->content = $this->viewParser->parseTags($this->content, $this->data, $this->fieldEntries);
    }

    private function _includedFile()
    {
        // Get the path to the view to extend
        preg_match_all("#^@include\(([\w+\/?]+.\w+.\w+)\)$#m", $this->content, $includeMethod, PREG_SET_ORDER, 0);

        if (is_null($includeMethod)) {
            return "";
        }

        foreach ($includeMethod as $tag) {
            $value = $tag[1];
            $html = null;
            $include = RenderFunction::include($value, $this->data);
            $this->content = preg_replace("#^@include\($value\)$#m", $include, $this->content);
        }
    }


    private function _compileForm(bool $debug = false)
    {
        $this->_parseTemplate();
        $this->_parseTags();
    }

}