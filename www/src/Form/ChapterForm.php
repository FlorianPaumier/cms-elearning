<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;

class ChapterForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $formBuilder): FormBuilder
    {
        return $formBuilder
            ->add("name", TextType::class, [
                "label" => "Nom",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("position",TextType::class, [
                "label" => "Chapitre",
                "type" => "number",
                "require" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("blocks", CollectionType::class,  [
                "label" => "Contenu",
                'entry_type' => ChapterBlockForm::class,
                "prototype_name" => "__BLOCKS__",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ]);
    }

    /**
     * @inheritDoc
     */
    /**
     * @inheritDoc
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix ?? "admin_chapter";
    }

    public function getBlockPrefix()
    {
        return "admin_chapter";
    }

}