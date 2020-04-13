<?php


namespace App\Core\Interfaces;


use App\Core\Form\FormBuilder;

interface FormTypeInterface
{
    /**
     * Function to get the validation rules for the form
     */
    public static function getConstraint(): array;

    /**
     * @return mixed
     * Create the input to show
     */
    public function buildForm(FormBuilder $builder): FormBuilder;

    /**
     * Set prefix for input
     * @param string $prefix
     */
    public function setBlockPrefix(string $prefix): void;

    public function getBlockPrefix(): string;

}