<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\SelectType;
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
            ->add("thumbnail", ImageType::class, [
                "label" => "Thumbnail",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("description", TextAreaType::class, [
                "label" => "Description",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->add("content", TextAreaType::class, [
                "label" => "Introduction du cours",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ])
            ->add("chapters", SelectType::class, [
                "label" => "Chapitres",
                "required" => false,
                "choices" => [
                    "1" => "one",
                    "2" => "two",
                    "3" => "three",
                ],
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