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
                        ->add('nom', TextType::class , array (
  'require' => true,
  'placeholder' => 'Nom',
  'label' => 'Nom',
  'key' => 'nom',
  'position' => '1',
))
                        ->add('pr_nom', TextType::class , array (
  'require' => true,
  'placeholder' => 'Prénom',
  'label' => 'Prénom',
  'key' => 'pr_nom',
  'position' => '2',
))
                        ->add('email', TextType::class , array (
  'require' => true,
  'placeholder' => 'email',
  'label' => 'email',
  'key' => 'email',
  'position' => '3',
))
                        ->add('subject', TextType::class , array (
  'require' => false,
  'placeholder' => 'subect',
  'label' => 'subject',
  'key' => 'subject',
  'position' => '4',
))
                        ->add('message', TextAreaType::class , array (
  'require' => true,
  'placeholder' => 'Message',
  'label' => 'Message',
  'key' => 'message',
  'position' => '5',
))
                        ->add('valider', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'Valider',
  'label' => 'Valider',
  'key' => 'valider',
  'position' => '6',
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