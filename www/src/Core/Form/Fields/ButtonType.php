<?php


namespace App\Core\Form\Fields;


class ButtonType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ButtonType.tpl.php";
    }

    public function getBlockName(){
        return "button";
    }
}