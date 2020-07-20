<?php

namespace App\Form;

use App\Core\Form\Fields\DateTimeType;
use App\Core\Form\Fields\DateType;
use App\Core\Form\FormBuilder;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextType;
use App\Core\Form\Fields\SubmitType;


class StreamForm extends AbstractForm
{

    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add('identifiant', TextType::class, array(
                'require' => true,
                'placeholder' => 'Identifiant Twitch',
                'label' => 'Identifiant Twitch',
            ))
            ->add('start_at', DateType::class, array(
                'require' => true,
                'type' => "datetime-local",
                'label' => 'Date de début',
            ))
            ->add('submit', SubmitType::class, array(
                'require' => false,
                'placeholder' => 'Submit',
                'label' => 'Submit',
            ));
    }


    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null)
    {
        $this->prefix = "test";
    }

    public function getBlockPrefix(): string
    {
        return $this->prefix ?? "admin_form_stream";
    }


}