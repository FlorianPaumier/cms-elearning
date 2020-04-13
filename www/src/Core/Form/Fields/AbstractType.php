<?php


namespace App\Core\form\Fields;


use App\Core\Render\RenderView;

abstract class AbstractType
{
    private $render;

    public function __construct()
    {
        $this->render = new RenderView();
    }

    protected function renderElement(string $type = TextType::class, array $args = []){
        return $this->render->renderHtmlElement($type, $args);
    }
}