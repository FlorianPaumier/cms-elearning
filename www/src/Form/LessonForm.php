<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;
use App\Entity\Lesson;
use App\Entity\LessonChapter;

class LessonForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("title", TextType::class, [
                "label" => "Title",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("description", TextAreaType::class, [
                "label" => "Description",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->add("chapters", EntityType::class, [
                "label" => "Chapitres",
                "required" => true,
                "multiple" => true,
                "entry_type" => LessonChapter::class,
                "class" => "col-md-6 col-lg-6 col-sm-12 select-two",
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    public function getBlockPrefix(): string
    {
        return "admin_lesson";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Lesson::class
        ];
    }

}