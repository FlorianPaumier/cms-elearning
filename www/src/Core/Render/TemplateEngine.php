<?php


namespace App\Core\Render;


use App\Core\Cache\CacheHandler;
use App\Core\Form\Fields\FieldsInterface;
use App\Core\Cache\ConfigHandler;

class TemplateEngine
{
    #region Field
    private const TPL_EXT = [
        ".view.php",
        ".tpl.php",
    ];

    /**
     * @var string
     */
    private $view;

    /** @var string */
    private $content;

    /** @var string */
    private $extendsContent;

    /** @var array */
    private $data;

    /** @var array */
    private $fieldEntries;

    /** @var array */
    private $methodEntries;

    /** @var array */
    private $extendMethod;

    /** @var array */
    private $blockEntries;

    /** @var array */
    private $functions = [];

    /** @var ParseView */
    private $viewParser;

    /** @var string */
    private $cacheDir;

    /** @var bool */
    private $rendering;

    #endregion

    public function __construct()
    {
        $this->viewParser = new ParseView();
        $this->cacheDir = CACHE_PATH . "/views/";
    }

    /**
     * Retrieve the template file if it's in the default extentions or if it's the absolute path
     * @param string $view
     * @return bool
     */
    public function setView(string $view)
    {

        foreach (self::TPL_EXT as $ext) {
            if (file_exists(VIEW_PATH . DIRECTORY_SEPARATOR . $view . $ext)) {
                $this->view = VIEW_PATH . DIRECTORY_SEPARATOR . $view . $ext;
            } elseif (file_exists($view . $ext)) {
                $this->view = $view . $ext;
            } elseif (file_exists(FORM_PATH . "/$view$ext")) {
                $this->view = $view . $ext;
            } elseif (file_exists($view)) {
                $this->view = $view;
                break;
            }
        }

        if (empty($this->view)) {
            ConfigHandler::get("eventEmmiter")->emit("error.404", "$view not found");
        }

        return true;
    }

    /**
     * define the data to insert into the view
     * @param array $data
     */
    public function setData(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Parse the view and insert or extend the views
     * @param array $extra
     * @throws \Exception
     */
    public function generate_markup($extra = [])
    {
        if (!CacheHandler::exist($this->view)) {
            $this->_load_template();
            $this->_extendFile();
            $this->_includedFile();

            if ($_SERVER["APP_ENV"] == "dev") {
//                CacheHandler::set($this->view, $this->content);
            }
        } else {
            $this->content = CacheHandler::get($this->view);
        }
    }

    /**
     * Retrieve the content of the view
     */
    private function _load_template()
    {
        if (file_exists($this->view) && is_readable($this->view)) {
            $this->content = file_get_contents($this->view);
        }
    }

    /**
     * Parse the view for tags and functions and save the results
     */
    private function _parseTemplate()
    {
        preg_match_all("/{{\s?(\w+)\s?}}/m", $this->content, $this->fieldEntries, PREG_SET_ORDER, 0);
        preg_match_all("/@(\w+)\((.*?)(,(\[?.*?\]?))?\)/m", $this->content, $this->methodEntries, PREG_SET_ORDER, 0);
    }

    /**
     * Render the html element to create a form
     *
     * @param mixed $type
     * @return string
     */
    public function renderHtmlElement($type)
    {
        if ($type instanceof FieldsInterface) {
            $block = $type::getBlockName();
        } else {
            $block = $type;
        }

        $this->_load_template();

        if ($type == "errors") {
            dump($this->content, "Template Content");
        }

        preg_match_all("#.*@block\($block\)((?s:.+?))@endblock.*#m", $this->content, $this->blockEntries, PREG_SET_ORDER, 0);

        if ($type == "errors") {
            dump($this->blockEntries, "Block Entries");
        }

        $this->content = $this->blockEntries[0][1] ?? "";
        $debug = $type == "errors" ? true : false;
        $this->_compileForm($debug);
        return $this->content;
    }

    /**
     * Resolve all the tags to create the view
     * Todo : Set the skeleton in cache
     * @param bool $tags
     * @return string|string[]|null
     * @throws \Exception
     */
    public function compile(bool $tags = true)
    {
        $this->_parseTemplate();


        if ($tags) {
            $this->content = $this->getParsePhpView($this->content, $this->data["parameter"]);

            if (count($this->fieldEntries) > 0) {
                $this->_parseTags();
                $this->_parseTemplate();

                if (count($this->methodEntries) > 0) {
                    $this->_parseFunctions($this);
                }
            }

            foreach ($this->functions as $regex => $function) {
                $this->content = preg_replace("#$regex#", $function, $this->content);
            }
        }

        if (isset($this->data["render"]) && $this->data["render"]) {
            return $this->content;
        }

        if (!is_null($this->view) && $tags) {
            return $this->getParsePhpView($this->content, $this->data);
        }elseif (!is_null($this->view)){
            return $this->content;
        }

        return false;
    }

    /**
     * Insert the view content in the extend file
     * @return string
     * @throws \Exception
     */
    private function _extendFile()
    {
        // Get the path to the view to extend
        preg_match_all("#@extend\(([^)]*)\)#m", $this->content, $this->extendMethod, PREG_SET_ORDER, 0);

        if (is_null($this->extendMethod)) {
            return "";
        }

        foreach ($this->extendMethod as $tag) {
            $value = $tag[1];
            $html = null;
            $this->content = RenderFunction::extend($value, $this->content);
        }

        if (preg_match("#@extend\(([^)]*)\)#m", $this->content)) {
            $this->_extendFile();
        }
    }

    /**
     * Retrieve the data for the functions tags
     * @param TemplateEngine|null $engine
     */
    private function _parseFunctions(TemplateEngine $engine = null)
    {
        $this->functions = $this->viewParser->parseFunction($this->data, $this->methodEntries, $engine);
    }

    /**
     * Retrieve the data for the data tags
     */
    private function _parseTags()
    {
        $this->content = $this->viewParser->parseTags($this->content, $this->data, $this->fieldEntries);
    }

    /**
     * Insert the content of the fil in the current view
     * @return string
     * @throws \Exception
     */
    private function _includedFile()
    {
        // Get the path to the view to extend
        preg_match_all("#@include\(([^)]*)\)#m", $this->content, $includeMethod, PREG_SET_ORDER, 0);

        if (is_null($includeMethod)) {
            return "";
        }

        foreach ($includeMethod as $tag) {
            $value = $tag[1];
            $html = null;
            $include = RenderFunction::include($value, $this->data);
            $this->content = preg_replace("#@include\($value\)#m", $include, $this->content);
        }
    }

    /**
     * Create the html form element
     * @param bool $debug
     */
    private function _compileForm(bool $debug = false)
    {
        $this->_parseTemplate();
        $this->_parseTags();
        $this->_parseTemplate();

        if (count($this->methodEntries) > 0) {

            $this->_parseFunctions($this);

            foreach ($this->functions as $regex => $function) {
                $this->content = preg_replace("#$regex#", $function, $this->content);
            }
        }
    }

    /**
     * Execute the php in the file
     * @param string $content
     * @param array $data
     * @return false|string
     */
    private function getParsePhpView(string $content, array $data)
    {
        ob_start();
        $tmp = tmpfile();
        fwrite($tmp, $content);
        extract($data);
        extract($this->data["config"]);

        require stream_get_meta_data($tmp)['uri'];
        return ob_get_clean();
    }
}