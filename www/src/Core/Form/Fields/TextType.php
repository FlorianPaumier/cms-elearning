<?php


namespace App\Core\Form\Fields;


class TextType extends AbstractType
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
    public function getBlockPrefix()
    {
        return 'text';
    }
}