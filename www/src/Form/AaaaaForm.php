<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\SubmitType;


class AaaaaForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
                        ->add('firsta', TextType::class , array (
  'require' => true,
  'placeholder' => 'qds',
  'label' => 'Firsta',
  'key' => 'firsta',
  'position' => '0',
))
                        ->add('last', TextType::class , array (
  'require' => false,
  'placeholder' => '',
  'label' => 'Last ',
  'key' => 'last',
  'position' => '1',
))
                        ->add('dfs', TextAreaType::class , array (
  'require' => false,
  'placeholder' => 'fdg',
  'label' => 'dfs',
  'key' => 'dfs',
  'position' => '2',
))
                        ->add('aze', EmailType::class , array (
  'require' => false,
  'placeholder' => 'aze',
  'label' => 'aze',
  'key' => 'aze',
  'position' => '3',
))
                        ->add('dfg', SubmitType::class , array (
  'require' => false,
  'placeholder' => 'dfg',
  'label' => 'dfg',
  'key' => 'dfg',
  'position' => '4',
))
                ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "aaaaa";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}