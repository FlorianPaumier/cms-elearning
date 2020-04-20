<?php


namespace App\Core\Form\Fields;


use App\Core\Interfaces\FormTypeInterface;

interface FieldsInterface
{
    public static function getTemplate();

    public function getParent();

    public function setOptions(string $key, array $args);

    public function generatePrototype(FormTypeInterface $field);

    public function setParent(string $parent);

    public function getBlockPrefix();

    public function getConstraintOffset(string $key);
}