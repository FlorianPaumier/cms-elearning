<?php


namespace App\Core\Form\Fields;


class HiddenType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/TextType.tpl.php";
    }

    public function getBlockName(){
        return "hidden";
    }
}