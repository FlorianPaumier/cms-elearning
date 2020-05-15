<?php


namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Faq;
use App\Entity\LessonChapter;

class FaqForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("question", TextType::class, [
                "label" => "Question",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("reponse", TextType::class, [
                "label" => "Réponse",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    public function getBlockPrefix(): string
    {
        return "admin_faq";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Faq::class
        ];
    }

}