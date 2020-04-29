<?php


namespace App\Core\Form\Fields;


class TextAreaType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/TextAreaType.tpl.php";
    }

    public function getBlockName(){
        return "textarea";
    }
}