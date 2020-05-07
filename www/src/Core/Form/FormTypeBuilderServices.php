<?php


namespace App\Core\Form;


use App\Core\Form\Fields\AddressType;
use App\Core\Form\Fields\CaptchaType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\DateType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\IntegerType;
use App\Core\Form\Fields\PhoneType;
use App\Core\Form\Fields\SubmitType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Helpers\StringTransformer;
use App\Entity\ContactForm;

class FormTypeBuilderServices
{

    const AuthorizeEntryName = [
        "label_input",
        "type_input",
        "require_input",
        "placeholder_input",
        "position_input"
    ];

    private $data = [];
    private $template = ROOT_PATH . "/src/Core/Form/Templates/FormType.tpl.php";
    private $fields = [];
    private $usesType = [];
    private $prefix = "";

    public function __construct(array $data)
    {
        $this->data = $data;

    }

    public function generate()
    {
        foreach ($this->data as $field) {
            $slug = StringTransformer::slugify($field["label_input"]);
            $this->fields[$slug] = [
                "parameters" => [
                    "require" => !is_null($field["require_input"]),
                    "placeholder" => $field["placeholder_input"],
                    "label" => $field["label_input"],
                    "key" => $slug,
                    "position" => $field["position_input"]
                ],
                "type" => $this->translateType($field["type_input"]),
            ];
        }

        return $this;
    }


    public function createFormTypeClass(array $data): ContactForm
    {
        $className = $data["admin_contact_class"];

        $this->generateFile([
            "form_fields" => $this->fields,
            "usesType" => array_unique($this->usesType),
            "class_name" => StringTransformer::toPascalCase($className)."Form",
            "prefix" => StringTransformer::slugify($className)
        ]);

        $form = new ContactForm();

        return $form->setName($className)
            ->setEnabled($data["admin_contact_enable"])
            ->setPath("App\Form\\". StringTransformer::toPascalCase($className)."Form");
    }

    private function translateType(string $type)
    {

        switch ($type) {
            case "text":
                $this->usesType[] = TextType::class;
                return "TextType::class";
            case "checkbox":
                $this->usesType[] = CheckboxType::class;
                return "CheckboxType::class";
            case "integer":
                $this->usesType[] = IntegerType::class;
                return "IntegerType::class";
            case "date":
                $this->usesType[] = DateType::class;
                return "TextType::class";
            case "phone":
                $this->usesType[] = PhoneType::class;
                return "PhoneType::class";
            case "address":
                $this->usesType[] = AddressType::class;
                return "AddressType::class";
            case "captcha":
                $this->usesType[] = CaptchaType::class;
                return "CaptchaType::class";
            case "textarea":
                $this->usesType[] = TextAreaType::class;
                return "TextAreaType::class";
            case "email":
                $this->usesType[] = EmailType::class;
                return "EmailType::class";
            case "submit":
                $this->usesType[] = SubmitType::class;
                return "SubmitType::class";
        }
    }

    private function generateFile($data)
    {
        dump($data["form_fields"]);
        ob_start();
        uasort($data["form_fields"], function ($a, $b) {
            return $a["parameters"]["position"] > $b["parameters"]["position"];
        });

        extract($data);
        require $this->template;
        $content = ob_get_clean();
        dump($data["form_fields"]);
        file_put_contents(ROOT_PATH . "/src/Form/" . $data["class_name"] . ".php", $content);
        return ROOT_PATH . "/src/Form/" . $data["class"] . ".php";
    }
}