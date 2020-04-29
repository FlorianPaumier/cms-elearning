<?php


namespace App\Core\Form\Fields;


class CheckboxType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ChoiceType.tpl.php";
    }

    public function getBlockName(){
        return "checkbox";
    }
}