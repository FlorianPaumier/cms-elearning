<?php


namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Sondage;
use function App\Core\Form\Fields\CheckboxType;

class SondageForm extends AbstractForm
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("question", TextType::class, [
                "label" => "Question : ",
                "placeholder" => "Question du sondage",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("optionOne", TextType::class, [
                "label" => "Option 1 : ",
                "required" => true,
                "placeholder" => "Option 1",
                "class" => "cold-md-6 col-lg-6 col-sm-12",
            ])
            ->add("optionTwo", TextType::class, [
                "label" => "Option 2 : ",
                "required" => true,
                "placeholder" => "Option 2",
                "class" => "cold-md-6 col-lg-6 col-sm-12"
            ])
            ->add("optionThree", TextType::class, [
                "label" => "Option 3 : ",
                "placeholder" => "Option 3",
                "class" => "cold-md-6 col-lg-6 col-sm-12",
            ])
            ->add("optionFour", TextType::class, [
                "label" => "Option 4 : ",
                "placeholder" => "Option 4",
                "class" => "cold-md-6 col-lg-6 col-sm-12",
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    public function getBlockPrefix(): string
    {
        return "admin_sondage";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Sondage::class
        ];
    }

}