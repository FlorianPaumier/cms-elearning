<?php


namespace App\Core\Form;


abstract class FormType
{
    /**
     * @var Form
     */
    protected $formBuilder;

    /**
     * @var string
     */
    public $prefix = "app";

    protected $fields;

    public function __construct()
    {
        if(is_null($this->formBuilder)) {
            $this->formBuilder = new Form();
        }

        $this->getBlockPrefix();
    }

    /**
     * Add different parameter to test the form data
     */
    protected static function getConstraint()
    {

    }

    /**
     * Build a form skeleton
     */
    public function buildForm()
    {
        return [];
    }

    protected function createForm()
    {
    }

    /**
     * @return string
     */
    public function setBlockPrefix()
    {
        return "form";
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        $this->prefix = "app";
    }
}