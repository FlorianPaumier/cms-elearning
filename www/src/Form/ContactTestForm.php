<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\SubmitType;


class ContactTestForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('a', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'a',
  'label' => 'a',
  'key' => 'a',
  'position' => '3',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "contact_test";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}