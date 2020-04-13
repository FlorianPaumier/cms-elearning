<?php


namespace App\Core\form;


class FormFactory
{

    public function __construct()
    {
    }

    /**
     * Creates and returns a Form instance from the type of the form.
     */
    public function create(string $type, $data = null, array $options = [])
    {
        return $this->createBuilder($type, $data, $options)->getForm();
    }

    public function createBuilder(string $type, $data, array $options)
    {
        return $this->createNamedBuilder($this->registry->getType($type)->getBlockPrefix(), $type, $data, $options);
    }

    public function createNamedBuilder($getBlockPrefix, string $type, $data, array $options)
    {
    }
}