<?php

namespace Tests\Framework\Database;

use App\Core\Cache\ConfigHandler;
use App\Core\Form\FormBuilder;
use App\Core\Render\RenderView;
use App\Form\ChapterBlockForm;
use http\Client;
use PHPUnit\Framework\TestCase;

class RenderTest extends TestCase
{

    private $render;
    private $client;

    public function setUp(): void
    {
        $this->render = new RenderView();

        $this->client = new Client([
            "base_uri" => 'http://localhost:280'
        ]);
    }

    /**
     *
     */
    public static function setUpBeforeClass(): void
    {
        define("ROOT_PATH", dirname(__DIR__));
        define("VIEW_PATH", ROOT_PATH . "/public/views");
        define("FORM_PATH", ROOT_PATH . "/src/Core/Form");
        define("CACHE_PATH", ROOT_PATH . "/app/cache");
        define("CONFIG_PATH", ROOT_PATH . "/app/config");
        define("ROUTING_PATH", ROOT_PATH . "/app/routing");
        define("PATH_STYLE", ROOT_PATH . "/public/styles");
        define("PATH_SCRIPT", ROOT_PATH . "/public/scripts");
        define("PATH_LIBRARY", ROOT_PATH . "/node_modules");
        define("PATH_FORM", ROOT_PATH . "/src/Core/Form/Templates");

    }

    public function testExtendFile(){
        $view = $this->render->render("test/extend");
        self::assertEquals("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>

</body>
</html>", $view->compile());
    }

    public function testIncludeFile(){
        $view = $this->render->render("test/include");
        self::assertEquals("<!-- Logout Modal-->
<div class=\"modal fade\" id=\"logoutModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\" role=\"document\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"exampleModalLabel\">Ready to Leave?</h5>
                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">×</span>
                </button>
            </div>
            <div class=\"modal-body\">Select \"Logout\" below if you are ready to end your current session.</div>
            <div class=\"modal-footer\">
                <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                <a class=\"btn btn-primary\" href=\"login.html\">Logout</a>
            </div>
        </div>
    </div>
</div>
", $view->compile());
    }

    public function testExtendWithSections()
    {
        $view = $this->render->render("test/extendWithSection", ["hello" => "hello"]);
        self::assertEquals("<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Title</title>
</head>
<body>

    hello


</body>
</html>", $view->compile());
    }

    public function testPathFunction()
    {
        $view = $this->client->get("/path");
        self::assertEquals("/admin/lesson", $view->compile());
    }

    public function testRenderForm()
    {
        $form = $this->createForm(ChapterBlockForm::class);
        $view = $this->render->render("test/form", ["form" => $form->createView()]);

        self::assertEquals("<form class=\"form-container\" action=\"\" method=\"POST\">
    
<div class=\"form-group\">
    <label for=\"app_form_title\">Nom</label>
    <input type=\"text\"
           id=\"app_form_title\"
           class=\"col-md-6 col-lg-6 col-sm-12 \" placeholder=\"Nom\"
           name=\"admin_chapter_block_title\" value=\"\" >
</div>

<div class=\"form-group\">
    <label for=\"app_form_content\">Contenu</label>
    <textarea type=\"text\" id=\"app_form_content\" class=\"col-md-6 col-lg-6 col-sm-12 ckeditor\" name=\"admin_chapter_block_content\" ></textarea>
</div>

</form>", $view->compile());
    }

    private  function createForm(string $type, &$data = null, array $options = []): FormBuilder
    {
        if(!class_exists($type)) throw new \Exception();

        $form = (new $type);
        $formBuilder = (new FormBuilder($data))->setParent($type)->setFormType($form);
        return $form->buildForm($formBuilder);
    }

}
