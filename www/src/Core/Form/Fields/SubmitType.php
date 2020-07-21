<?php


namespace App\Core\Form\Fields;


class SubmitType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ButtonType.tpl.php";
    }

    public function getBlockName(){
        return "button";
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'submit';
    }
}