<?php


namespace App\Core\form\Fields;


class TextType extends AbstractType implements FieldsInterface
{

    function getTemplate()
    {
        return PATH_FORM."/TextType.tpl.php";
    }

    function getAllAttributes()
    {
        // TODO: Implement getAllAttributes() method.
    }

    public function getBlockPrefix()
    {
        // TODO: Implement getBlockPrefix() method.
    }

    function generatePrototype(FormField $field)
    {
        // TODO: Implement generatePrototype() method.
    }

}