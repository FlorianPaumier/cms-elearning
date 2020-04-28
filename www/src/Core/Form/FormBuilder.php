<?php


namespace App\Core\Form;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\Table;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\ChoiceType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\FieldsInterface;
use App\Core\Form\Fields\OptionType;
use App\Core\Form\Validator\Validator;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Render\RenderView;
use App\Core\Request\Request;

class FormBuilder
{

    /** @var string */
    protected $prefix = "app";
    /** @var array */
    protected $inputs = [];
    /** @var array */
    private $fields = [];

    /** @var string */
    private $action = "";

    /** @var RenderView */
    private $render;

    /** @var array */
    private $form;

    /** @var array */
    private $data = [];

    /** @var array */
    private $errors = [];

    /** @var AbstractForm */
    private $parent;

    private $entity;

    /** @var FormTypeInterface */
    private $formType;
    /**
     * @var string
     */
    private $formParentType;

    /**
     * FormBuilder constructor.
     */
    public function __construct(object $entity = null)
    {
        $this->entity = $entity;
        $this->render = new RenderView();
        define("FORM_PATH", __DIR__);
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function add(string $key, string $field, array $args)
    {
        if (!class_exists($field)) {
            throw new \Exception();
        }

        $this->createType(new $field, $key, $args);
        return $this;
    }

    private function createType(FieldsInterface $field, string $key, array $args)
    {
        if (!$this->fieldExist($key, get_class($field), $args)) {
            ConfigHandler::get("eventEmmiter")->emit("error.500", "Field $key don't exist");
        }

        #Todo : Get data from Request ou Entity
        $value = $this->getValue($key);

        $args["value"] = $value;

        $args["type"] = $args["type"] ?? $field->getBlockType();
        $args["key"] = $key;


        $field = $this->translateField($field, $args);

        if (!is_null($this->parent) && class_exists($this->parent)) {
            $field->setParent(new $this->parent);
        }

        $args = $this->setName($field, $args);
        $field->setOptions($key, $args);
        $this->form[$field->getConstraintOffset("name")] = $field;
        $this->fields[$field->getConstraintOffset("name")] = ["key" => $key, "type" => get_class($field), "args" => $args];

        return $this->form[$field->getConstraintOffset("name")];
    }

    public function handleRequest(Request $request)
    {
        $keysForm = array_keys($this->form);

        foreach ($keysForm as $key) {
            if (key_exists($key, $request->getQuery()->all())) {
                $value = $request->getQuery()->get($key);
            } else {
                if (key_exists($key, $request->getRequest()->all())) {
                    $value = $request->getRequest()->get($key);
                }
            }

            if (is_null($value)) {
                break;
            }

            #TODO : Transforme les Entity / Collection Type
            if (is_null($this->entity) || is_array($this->entity)) {
                $this->entity[$key] = $value;
            } else {
                if (is_object($this->entity)) {
                    $method = "set";
                    if ($this->fields[$key]["type"] == EntityType::class) {
                        /** @var Table $repository */
                        $repository = ConfigHandler::get('repository');
                        $repository->getClass($this->fields[$key]["args"]["entry_type"]);
                        $value = $repository->setEntity($this->fields[$key]["args"]["entry_type"])->find($value);
                    }

                    $method .= ucfirst($this->fields[$key]["key"]);
                    if (method_exists($this->entity, $method)) {
                        $mirrorMethod = new \ReflectionMethod($this->entity, $method);

                        if ($value instanceof $mirrorMethod->class) {
                            $this->entity->$method($value);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $key
     * @return mixed|string|null
     */
    private function getValue(string $key)
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? null;
        }

        $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

        $value = $this->data->$method();

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    public function isValid()
    {
        $validator = new Validator($this->fields);
        $this->errors = $validator->getErrors();

        return $validator->isValid();
    }

    public function setFormParentType(string $class)
    {
        $this->formParentType = $class;
        return $this;
    }

    private function getInputClass(string $key, array $options = []): string
    {
        $inputClass = '';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }

        if (isset($options["class"])) {
            $inputClass .= ' ' . $options["class"];
        }

        return $inputClass;
    }

    public function getErrorFeedback(): array
    {
        return $this->errors;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param string $error
     */
    public function addError(string $key, string $error)
    {
        $this->errors[$key] = $error;
    }

    public function removeError(string $key)
    {
        unset($this->errors[$key]);
    }

    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param mixed $parent
     * @return FormBuilder
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @param bool $prototype
     * @return RenderView|string|string[]|null
     * @throws \Exception
     */
    public function createView(bool $prototype = false)
    {
        $html = implode(
            "", array_map(
                function ($input) {
                    if(!is_null($input->getHtml())) return $input->getHtml();
                    return html_entity_decode($input->renderElement());
                }, $this->form
            )
        );

        if ($prototype) {
            return $html;
        }

        return $this->render->render(__DIR__ . "/form.view.php", [
            "form_view" => $html,
            "method" => "POST",
            "action" => $this->action,
        ], true);
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    private function translateField(FieldsInterface $field, array $args)
    {
        if ($field instanceof ChoiceType) {
            $options = [
                "multiple" => $args["multiple"] ?? false,
                "expanded" => $args["expanded"] ?? false,
            ];

            $field->translate($options);
        } else {
            if ($field instanceof EntityType) {
                $this->createEntityType($field, $args);
            }
            if ($field instanceof CollectionType) {
                $this->createCollectionType($field, $args);
            }
        }

        return $field;
    }

    private function fieldExist(string $key, string $field, array $args)
    {

        $options = (new $this->formType)->getOptions();

        if (!key_exists("data_class", $options) || $field === ButtonType::class || $args["mapped"] === false) {
            return true;
        }

        $entity = $options["data_class"];

        if (!class_exists($entity)) {
            ConfigHandler::get("eventEmmiter")->emit("error.404", "the $entity don't exist");
        }

        $methods = ["get", 'set', 'is'];

        foreach ($methods as $method) {

            $assesseur = $method . str_replace('_', '', ucwords($key, '_'));;

            if (method_exists($entity, $assesseur)) {
                return true;
            }
        }

        return false;
    }

    private function createEntityType(EntityType &$field, array $args)
    {
        if (!isset($args["entry_type"])) {
            ConfigHandler::get("eventEmmiter")->emit("error.500", "the key entry_type must be not null");
        }

        /** @var Table $repository */
        $repository = ConfigHandler::get('repository');
        $repository->getClass($args["entry_type"]);
        $items = $repository->findAll();
        $options = [];

        foreach ($items as $item) {
            $type = new OptionType();
            $type->setParent($field);
            $type->addArgs([
                "value" => $item[$args["choice_label"]],
                "key" => $item["id"]
            ]);

            $options[] = $type->renderElement();

        }

        $field->addData("optionsHTML", implode("", $options));
    }

    private function createCollectionType(CollectionType &$field, array $args)
    {
        if(!key_exists("entry_type", $args)){
            ConfigHandler::get("eventEmmiter")->emit("error.500", "The entry_type option must be not null");
        }

        $class = $args["entry_type"];

        if (!class_exists($class)) {
            ConfigHandler::get("eventEmmiter")->emit("error.404", "The $class don't exist");
        }

        /** @var FormTypeInterface $form */
        $form = new $class;
        $form->setParent($this->parent);
        $form->setParentPrefix((new $this->parent)->getBlockPrefix());

        $field->setParent($this->parent);
        $field->generatePrototype($args["key"], $form, $args);
    }

    /**
     * @return FormTypeInterface
     */
    public function getFormType(): FormTypeInterface
    {
        return $this->formType;
    }

    /**
     * @param FormTypeInterface $formType
     */
    public function setFormType(FormTypeInterface $formType)
    {
        $this->formType = $formType;
        return $this;
    }

    private function setName(FieldsInterface $field, array $args): array
    {
        if (!is_null($this->formParentType)){
            $args["name"] = $this->formType->getBlockPrefix() . "[".$args["key"]."]";
        }

        return $args;
    }

}
