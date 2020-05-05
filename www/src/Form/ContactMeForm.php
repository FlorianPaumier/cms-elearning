<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\TextAreaType;


class ContactMeForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('aaaa', TextType::class , array (
  'require' => false,
  'placeholder' => 'zzz',
  'label' => 'aaaa',
  'key' => 'aaaa',
  'position' => '0',
))
                        ->add('eee', EmailType::class , array (
  'require' => false,
  'placeholder' => 'rrrr',
  'label' => 'eee',
  'key' => 'eee',
  'position' => '1',
))
                        ->add('tttt', TextAreaType::class , array (
  'require' => true,
  'placeholder' => 'yyyy',
  'label' => 'tttt',
  'key' => 'tttt',
  'position' => '2',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "contact_me";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}