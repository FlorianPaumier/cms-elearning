<?php


namespace App\Core\Form\Fields;


class ChoiceInputType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ChoiceInputType.tpl.php";
    }


    public function getBlockName(){
        return "inputs";
    }

}