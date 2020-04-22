<?php


namespace App\Core\Interfaces;


use App\Core\Form\FormBuilder;

interface FormTypeInterface
{
    /**
     * Create and define the the form
     * @param FormBuilder $builder
     * @return FormBuilder
     */
    public function buildForm(FormBuilder $builder);


    /**
     * Retrieve the form prefix
     * @return string
     */
    public function getBlockPrefix();

    /**
     * Define the input prefix for the form
     * @param string|null $prefix
     */
    public function setBlockPrefix(string $prefix = null);

    /**
     * Configures the options for this type.
     */
    public function configureOptions();

    /**
     * Returns the name of the parent type.
     *
     * @return string|null The name of the parent type if any, null otherwise
     */
    public function getParent();
}