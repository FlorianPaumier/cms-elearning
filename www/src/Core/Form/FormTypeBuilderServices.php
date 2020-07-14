<?php


namespace App\Core\Form;


use App\Core\Cache\ConfigHandler;
use App\Core\Contact\ContactForm;
use App\Core\Contact\ContactInput;
use App\Core\Evaluation\Evaluation;
use App\Core\Form\Fields\AddressType;
use App\Core\Form\Fields\CaptchaType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\SimpleCheckboxType;
use App\Core\Form\Fields\DateType;
use App\Core\Form\Fields\EmailType;
use App\Core\Form\Fields\IntegerType;
use App\Core\Form\Fields\PhoneType;
use App\Core\Form\Fields\SubmitType;
use App\Core\Form\Fields\TextAreaType;
use App\Core\Form\Fields\TextType;
use App\Core\Formatter\Serializer;
use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\GenerateFormInterface;

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
    private $inputs = [];

    /** @var Serializer */
    private $serializer;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->serializer = new Serializer();
    }

    public function generateContact(string $class, GenerateFormInterface $form = null): self
    {
        foreach ($this->data as $field) {
            $slug = StringTransformer::slugify($field["label_input"]);
            $this->fields[$slug] = [
                "parameters" => [
                    "require" => !is_null($field["require_input"]),
                    "placeholder" => $field["placeholder_input"],
                    "label" => $field["label_input"],
                    "key" => $slug,
                    "position" => $field["position_input"],
                    "choices" => $this->translateChoices($field["choice_input"]),
                ],
                "type" => $this->translateType($field["type_input"]),
            ];

            $this->inputs[$slug] = (new $class())
                ->setFormKey($slug)
                ->setType($field["type_input"])
                ->setPlaceholder($field["placeholder_input"])
                ->setLabel($field["label_input"])
                ->setRequired(!is_null($field["require_input"]))
                ->setPosition($field["position_input"])
                ->setChoices($this->fields[$slug]["parameters"]["choices"]);

            if (!empty($field["id_input"])) {
                $this->inputs[$slug]->setId((int)$field["id_input"]);
            }
            if (!is_null($form)) {
                if ($form instanceof ContactForm) {
                    $this->inputs[$slug]->setContactForm($form);
                } elseif ($form instanceof Evaluation) {
                    $this->inputs[$slug]->setEvaluation($form);
                }
            }
        }

        return $this;
    }

    public function createFormTypeClass(array $data, string $class, GenerateFormInterface $form = null): GenerateFormInterface
    {
        $ext = ["admin_evaluation", "admin_contact"];

        if (key_exists($ext[0], $data)) {
            $key = $ext[0];
        } else {
            if (key_exists($ext[0], $data)) {
                $key = $ext[0];
            }
        }
        $className = $data[$key . "_class"];

        $this->generateFile([
            "form_fields" => $this->fields,
            "usesType" => array_unique($this->usesType),
            "class_name" => StringTransformer::toPascalCase($className) . "Form",
            "prefix" => StringTransformer::slugify($className)
        ]);

        if (is_null($form)) {
            $form = new $class();
        }

        return $form->setName($className)
            ->setEnabled(!is_null($data[$key . "_enable"]))
            ->setPath("App\Form\\" . StringTransformer::toPascalCase($className) . "Form");
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    private function translateType(string $type): string
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
            default:
                return "TextType::class";
        }
    }

    private function generateFile($data)
    {
        ob_start();
        uasort($data["form_fields"], function ($a, $b) {
            return $a["parameters"]["position"] > $b["parameters"]["position"];
        });

        extract($data);
        require $this->template;
        $content = ob_get_clean();
        file_put_contents(ROOT_PATH . "/src/Form/" . $data["class_name"] . ".php", $content);

        return ROOT_PATH . "/src/Form/" . $data["class"] . ".php";
    }

    private function translateChoices(string $choicesString): ?array
    {
        $choices = [];

        $choicesArray = explode(",", $choicesString);
        foreach ($choicesArray as $choice) {
            $value = explode(":", $choice, 2);
            $choices[$value[0]] = $value[1];
        }

        return $choices;
    }
}