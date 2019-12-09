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
    protected $prefix;

    protected $fields;

    public function __construct(){
        $this->formBuilder = new Form();
    }

    /**
     * Add different parameter to test the form data
     */
    protected static function getConstraint(){

    }

    /**
     * Build a form skeleton
     */
    protected function buildForm(){
        return [];
    }


    /**
     * @return string
     */
    protected function createForm(){}

    /**
     *
     */
    protected function getBlockPrefix(){
        $this->prefix = "app";
    }
}