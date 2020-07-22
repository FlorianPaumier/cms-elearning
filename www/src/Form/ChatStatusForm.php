<?php


namespace App\Form;


use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\RadioType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Form\FormBuilder;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\ChatOnline;
use App\Repository\CategoryRepository;

class ChatStatusForm extends AbstractForm
{
    public function buildForm(FormBuilder $builder): FormBuilder
    {
        return $builder
            ->add("status", SelectType::class, [
                "label" => "Status",
                "placeholder" => "Status",
                "required" => true,
                "class" => "col-md-6 col-lg-6 col-sm-12 chat-status-select",
                "choices" => [
                    0 => 'Absent',
                    1 => 'Occupée',
                    2 => 'En ligne'
                ]
            ]);
    }

    public function setBlockPrefix(string $prefix = null): void
    {
        $this->prefix = $prefix;
    }

    public function getBlockPrefix(): string
    {
        return "chat_status";
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(){
        $this->options = [
            "data_class" => ChatOnline::class
        ];
    }
}