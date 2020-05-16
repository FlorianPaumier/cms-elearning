<?php


namespace App\Core\Form;


use App\Core\Interfaces\FormTypeInterface;

abstract class AbstractForm implements FormTypeInterface
{
    protected $prefix = "";

    protected $options = [];

    protected $parent;

    protected $parentPrefix;

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
    public function setBlockPrefix(string $prefix = null) {
        $this->prefix = $prefix;
    }

    /**
     * @return mixed
     */
    public function configureOptions(){}

    /**
     * @return mixed
     */
    public function getParent(){
        return $this->parent;
    }
    /**
     * @return mixed
     */
    public function setParent($parent){
        $this->parent = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function setParentPrefix($parent){
        $this->parentPrefix = $parent;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getParentPrefix(){
        return $this->parentPrefix;
    }
}