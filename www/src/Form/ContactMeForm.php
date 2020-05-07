<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\SubmitType;


class ContactMeForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('0', EmailType::class , array (
  'require' => true,
  'placeholder' => 'Email',
  'label' => 'Email',
  'key' => 'email',
  'position' => '0',
))
                        ->add('1', TextAreaType::class , array (
  'require' => true,
  'placeholder' => 'Message',
  'label' => 'Message',
  'key' => 'message',
  'position' => '1',
))
                        ->add('2', SubmitType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'Valider',
  'key' => 'valider',
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