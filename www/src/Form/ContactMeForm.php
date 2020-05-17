<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\SubmitType;


class ContactMeForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('af', TextType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'af',
  'key' => 'af',
  'position' => '0',
))
                        ->add('aa', TextAreaType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'aa',
  'key' => 'aa',
  'position' => '1',
))
                        ->add('f', TextType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'f',
  'key' => 'f',
  'position' => '2',
))
                        ->add('ad', SubmitType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'ad',
  'key' => 'ad',
  'position' => '3',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "contactme";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}