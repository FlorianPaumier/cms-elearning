<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\FormBuilder;
use App\Entity\Newsletter;

class NewsletterEmailForm extends AbstractForm
{
    /**
     * @param FormBuilder $builder
     * @return FormBuilder
     * @throws \Exception
     */
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("email", EmailType::class,[
                "label" => "Email",
                "placeholder" => "Entrez votre email...",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12",
            ])
            ->add("valider", ButtonType::class, [
                "label" => "Valider",
                "class" => "btn-submit",
                "type" => "submit",
            ]);
    }

    /**
     * @param string|null $prefix
     */
    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return "admin_newsletter";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => Newsletter::class
        ];
    }
}