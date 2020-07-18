<?php


namespace App\Core\Form\Fields;


class DateType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/DateType.tpl.php";
    }

    public function getBlockType(){
        return "date";
    }

    public function getBlockName(){
        return "date";
    }
}