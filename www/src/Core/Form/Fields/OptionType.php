<?php


namespace App\Core\Form\Fields;


class OptionType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ChoiceType.tpl.php";
    }

    public function getBlockName(){
        return "option";
    }

}