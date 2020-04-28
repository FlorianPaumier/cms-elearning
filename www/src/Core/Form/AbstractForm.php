<?php


namespace App\Core\Form;


use App\Core\Interfaces\FormTypeInterface;

abstract class AbstractForm implements FormTypeInterface
{
    protected $prefix;

    protected $options = [];

    public function __construct()
    {
        $this->configureOptions();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param FormBuilder $builder
     * @return FormBuilder
     */
    public function buildForm(FormBuilder $builder) {}

    /**
     * @return string
     */
    public function getBlockPrefix(){}

    /**
     * @param string|null $prefix
     */
    public function setBlockPrefix(string $prefix = null) {}

    /**
     * @return mixed
     */
    public function configureOptions(){}

    /**
     * @return mixed
     */
    public function getParent(){}
}