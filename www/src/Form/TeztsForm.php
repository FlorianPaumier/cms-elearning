<?php

namespace App\Form;

use App\Core\Form\Fields\RadioType;
use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\SubmitType;


class TeztsForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('qsdqsd', RadioType::class , array (
  'require' => false,
  'placeholder' => 'Placehokldr',
  'label' => 'qsdqsd',
  'key' => 'qsdqsd',
  'position' => '1',
  'choices' => 
  array (
    0 => 'non',
    1 => 'oui',
    'plus' => 'ultra',
  ),
))
                        ->add('label', TextType::class , array (
  'require' => false,
  'placeholder' => 'Placehodlder',
  'label' => 'Label',
  'key' => 'label',
  'position' => '2',
  'choices' => 
  array (
    0 => 'null',
  ),
))
                        ->add('submit', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'Submit',
  'label' => 'Submit',
  'key' => 'submit',
  'position' => '3',
  'choices' => 
  array (
    0 => 'null',
  ),
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