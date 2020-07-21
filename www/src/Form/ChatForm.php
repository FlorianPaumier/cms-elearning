<?php


namespace App\Form;

use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\ChatGlobal;

class ChatForm extends AbstractForm
{
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("message", TextType::class,[
                "label" => "message",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
                "placeholder" => "message..."
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return "frontend_chat";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions()
    {
        $this->options = [
            "data_class" => ChatGlobal::class
        ];
    }
}