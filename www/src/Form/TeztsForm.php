<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\SubmitType;


class TeztsForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('qsdqsd', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'Placehokldr',
  'label' => 'qsdqsd',
  'key' => 'qsdqsd',
  'position' => '1',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "tezts";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}