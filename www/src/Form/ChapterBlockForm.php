<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ChapterBlockForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $formBuilder): FormBuilder
    {
        return $formBuilder
            ->add("title", TextType::class, [
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("content",  TextAreaType::class , [
                "label" => "Contenu",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 ckeditor",
            ]);
    }

    /**
     * @inheritDoc
     */
    public function setBlockPrefix(): void
    {
        $this->prefix = "admin_lesson";
    }

    public function getBlockPrefix()
    {
        return  "admin_chapter_block";
    }
}