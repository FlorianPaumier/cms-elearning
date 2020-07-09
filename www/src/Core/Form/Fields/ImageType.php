<?php


namespace App\Core\Form\Fields;


class ImageType extends AbstractType
{

    public static function getTemplate()
    {
        return PATH_FORM."/ImageType.tpl.php";
    }

    public function getBlockName(){
        return "input";
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockType()
    {
        return 'file';
    }
}