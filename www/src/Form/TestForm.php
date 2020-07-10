<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\SubmitType;


class TestForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('label', TextType::class , array (
  'require' => false,
  'placeholder' => 'Placehodlder',
  'label' => 'Label',
  'key' => 'label',
  'position' => '1',
))
                        ->add('submit', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'Submit',
  'label' => 'Submit',
  'key' => 'submit',
  'position' => '2',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "test";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}