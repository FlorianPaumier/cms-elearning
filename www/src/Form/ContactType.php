<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ContactType extends FormBuilder implements FormTypeInterface
{
    /**
    * @inheritDoc
    */
    public static function getConstraint(): array
    {
        return array (
  0 => 
  array (
    'title' => 
    array (
      'empty' => false,
      'required' => true,
      'exists' => true,
    ),
  ),
  1 => 
  array (
    'description' => 
    array (
      'empty' => false,
      'required' => true,
      'exists' => true,
    ),
  ),
) ;
    }
    public function buildForm(): FormBuilder
    {
        return $this
                                    ->textarea('name', array (
  'label' => 'Title',
  'required' => true,
  'class' => 'col-md-6 col-lg-6 col-sm-12',
))
                                                ->input('first', array (
  'label' => 'first',
  'required' => true,
  'class' => 'col-md-6 col-lg-6 col-sm-12',
))
                            ;
    }


    /**
    * @inheritDoc
    */
    public function setBlockPrefix(): void
    {
        $this->prefix = "contact_form";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }


}