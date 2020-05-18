<?php


namespace App\Core\Form\Fields;


class SelectType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/SelectType.tpl.php";
    }

    public function getBlockName(){
        return "select";
    }
}