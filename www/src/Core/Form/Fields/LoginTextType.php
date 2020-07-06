<?php


namespace App\Core\Form\Fields;


class LoginTextType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/LoginTextType.tpl.php";
    }

    public function getBlockName(){
        return "input";
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockType()
    {
        return 'text';
    }
}