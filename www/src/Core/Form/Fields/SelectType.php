<?php


namespace App\Core\Form\Fields;


class SelectType extends ChoiceType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ChoiceType.tpl.php";
    }

    public function getBlockName(){
        return "select";
    }
}