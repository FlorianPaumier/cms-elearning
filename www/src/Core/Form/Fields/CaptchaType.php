<?php


namespace App\Core\Form\Fields;


class CaptchaType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/CaptchaType.tpl.php";
    }

    public function getBlockName(){
        return "captcha";
    }
}