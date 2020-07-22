<?php


namespace App\Core\Form\Fields;


class CheckboxType extends ChoiceType
{
    public function setHtml(string $html)
    {
        $this->html = $html;
        return $this;
    }
    public static function getTemplate()
    {
        return PATH_FORM."/ChoiceInputType.tpl.php";
    }

    public function getBlockName(){
        return "checkbox";
    }
}