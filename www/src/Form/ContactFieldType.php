<?php

namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\AbstractType;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ContactFieldType extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom du champs',
                'required' => true,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ))
            ->add('required', CheckboxType::class, array(
                'label' => 'Champs du formulaire',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ))
            ->add('minLength', TextType::class, array(
                'label' => 'Longueur minimal du champs',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
                'type' => 'integer',
            ))
            ->add('maxLength', TextType::class, array(
                'label' => 'Longueur minimal du champs',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
                'type' => 'integer',
            ))
            ->add('type', SelectType::class, array(
                'label' => 'Type du champs',
                'required' => false,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
                'choices' => [1,2,3],
            ))
            ->add('submit',ButtonType::class, array(
                'label' => 'Valider',
                'type' => 'submit',
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ));
    }


    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = $prefix ?? "contact_form_field";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix;
    }

}