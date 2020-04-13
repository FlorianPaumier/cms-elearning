<?php


namespace App\Core\form\Fields;


interface FieldsInterface
{
    function getTemplate();

    function getAllAttributes();

    function getBlockPrefix();

    function generatePrototype(FormField $field);
}