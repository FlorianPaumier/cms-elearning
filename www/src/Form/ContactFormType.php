<?php

namespace App\Form;

use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ContactFormType extends FormBuilder implements FormTypeInterface
{
    /**
     * @inheritDoc
     */
    public static function getConstraint(): array
    {
        return [
            [
                'name' =>
                    [
                        'empty' => false,
                        'required' => true,
                        'exists' => true,
                    ],
            ]
        ];
    }

    public function buildForm(): FormBuilder
    {
        return $this
            ->input('name', array(
                'label' => 'Nom du formulaire',
                'required' => true,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ))
            ->textarea('description', array(
                'label' => 'Description',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ))
            ->button('submit', array(
                'label' => 'Valider',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ));
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