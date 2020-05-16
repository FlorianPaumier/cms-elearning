<?php


namespace App\Core\Form\Fields;


class PasswordType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/TextType.tpl.php";
    }

    public function getBlockName(){
        return "input";
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockType()
    {
        return 'password';
    }
}