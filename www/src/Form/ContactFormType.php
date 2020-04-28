<?php

namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\AbstractType;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ContactFormType extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom du formulaire',
                'required' => true,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
            ))
            ->add('fields', CollectionType::class, array(
                'label' => 'Champs du formulaire',
                'required' => true,
                'class' => 'col-md-6 col-lg-6 col-sm-12',
                'entry_type' => ContactFieldType::class,
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
        $this->prefix = $prefix ?? "contact_form";
    }

    public function getBlockPrefix(): string
    {
        return "contact_form";
    }

}