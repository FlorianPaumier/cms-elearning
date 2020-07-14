<?php


namespace App\Core\Form;


use App\Core\Cache\ConfigHandler;
use App\Core\Collections\ArrayCollection;
use App\Core\Database\EntityManager;
use App\Core\Form\Fields\ButtonType;
use App\Core\Form\Fields\CheckboxType;
use App\Core\Form\Fields\ChoiceInputType;
use App\Core\Form\Fields\ChoiceType;
use App\Core\Form\Fields\CollectionType;
use App\Core\Form\Fields\DateType;
use App\Core\Form\Fields\EntityType;
use App\Core\Form\Fields\FieldsInterface;
use App\Core\Form\Fields\ImageType;
use App\Core\Form\Fields\OptionType;
use App\Core\Form\Fields\SelectType;
use App\Core\Form\Fields\SubmitType;
use App\Core\Form\Validator\Validator;
use App\Core\Helpers\FileUploader;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Render\RenderView;
use App\Core\Request\ParameterBag;
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

    /** @var ParameterBag */
    private $request;

    /** @var ParameterBag */
    private $query;

    /**
     * FormBuilder constructor.
     */
    public function __construct(object $entity = null)
    {
        $this->entity = $entity;
        $this->render = new RenderView();
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

    public function add(string $key, string $field, array $args = [])
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

        $args["value"] = $this->setValue($key);
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

        $this->request = $request->getRequest();

        foreach ($keysForm as $key) {
            preg_match_all('~\[\]~m', $key, $matches, PREG_SET_ORDER, 0);
            $requestKey = $key;
            $value = null;
            if (!empty($matches)) {
                $requestKey = preg_replace('~\[\]~', "", $key);
            }
            if (key_exists($requestKey, $request->getQuery()->all())) {
                $value = $request->getQuery()->get($requestKey);
            } else {
                if (key_exists($requestKey, $request->getRequest()->all())) {
                    $value = $request->getRequest()->get($requestKey);
                }
            }


            if (is_null($value)) {
                if (!key_exists($requestKey, $request->getFile())) {
                    break;
                }

                if (!empty($request->getFile()[$requestKey]) && $request->getFile()[$requestKey]["size"] > 0) {
                    $value = FileUploader::UploadFile($request->getFile()[$requestKey]);
                } else {
                    continue;
                }
            }

            if (is_null($this->entity) || is_array($this->entity)) {
                $this->entity[$key] = $value;
            } else {
                if (is_object($this->entity)) {

                    $method = "set";

                    $value = $this->transformValue($key, $value);

                    $property = $this->fields[$key]["key"];

                    $method .= ucfirst($property);
                    if (method_exists($this->entity, $method)) {
                        //                        /** @var \ReflectionMethod $methodReflection */
                        //                        $methodReflection = new \ReflectionMethod($this->entity, $method);
                        //
                        //                        /** @var \ReflectionParameter $parameter */
                        //                        $parameter = $methodReflection->getParameters()[0];
                        //                        $paramClass = $parameter->getClass()->getName();
                        //                        if($value instanceof $paramClass) dump("Hello");

                        if (gettype($value) == "array") {
                            foreach ($value as $entity) {
                                $this->entity->$method($entity);
                            }
                        } else {
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
        if (ConfigHandler::get("request")->getMethod() != "POST") {
            return false;
        }

        $validator = new Validator($this->fields, $this->parent);
        $this->errors = $validator->getErrors();

        return $validator->isValid($this->entity);
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
        $errors = $this->errors;
        $this->errors = [];
        return $errors;
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
            "",
            array_map(
                function ($input) {
                    if (!is_null($input->getHtml())) {
                        return $input->getHtml();
                    }

                    return html_entity_decode($input->renderElement());
                },
                $this->form
            )
        );

        if ($prototype) {
            return $html;
        }

        return $this->render->render(__DIR__ . "/form.view.php", [
            "form_view" => $html,
            "method" => "POST",
            "action" => $this->action,
            "enctype" => "multipart/form-data"
        ], true);
    }

    public function getInputs()
    {
        return $this->inputs;
    }

    public function get(string $key)
    {
        $prefix = $this->formType->getBlockPrefix();
        $index = "${prefix}_${key}";


        return $this->request->get($index);
    }


    private function translateField(FieldsInterface $field, array $args)
    {
        if ($field instanceof ChoiceType) {
            $options = [
                "multiple" => $args["multiple"] ?? false,
                "expanded" => $args["expanded"] ?? false,
            ];

            $field->translate($options);
            if ($field instanceof SelectType) {
                $this->createSelectType($field, $args);
            } else {
                $this->createChoiceInput($field, $args);
            }
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

        if (!key_exists("data_class", $options) || in_array($field, [ButtonType::class, SubmitType::class]) || $args["mapped"] === false) {
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

        $choiceLabel = $args["choice_label"] ? "get" . ucfirst($args["choice_label"]) : "getId";
        /** @var EntityManager $repository */
        $em = ConfigHandler::get('entityManager');
        $repository = $em->getRepository($args["entry_type"] . "Repository");

        $items = $repository->select('id', $args["choice_label"])->findAll();
        $options = [];

        foreach ($items as $item) {
            $type = new OptionType();
            $type->setParent($field);

            $select = "";

            if (!is_null($args["value"])) {
                if (get_class($args["value"]) == ArrayCollection::class) {
                    $elements = $args["value"]->toArray();
                    if (!is_null($elements)) {
                        foreach ($elements as $element) {
                            if ($element->getId() == $item->getId()) {
                                $select = "selected";
                            }
                        }
                    }
                } else {
                    if ($args["value"]->getId() == $item->getId()) {
                        $select = "selected";
                    }
                }
            }

            $type->setOptions($item->getId(), $args);
            $type->addArgs([
                "value" => $item->$choiceLabel(),
                "key" => $item->getId(),
                "selected" => $select ?? "",
            ]);

            $options[] = $type->renderElement();
        }

        $field->addData("optionsHTML", implode("", $options));
    }

    private function createCollectionType(CollectionType &$field, array $args)
    {
        if (!key_exists("entry_type", $args)) {
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
        if (!is_null($this->formParentType)) {
            $args["name"] = $this->formType->getBlockPrefix() . "[" . $args["key"] . "]";
        }

        if (isset($args["multiple"]) && $args["multiple"]) {
            $parent = new $this->parent;

            $args["name"] = $parent->getBlockPrefix() . "_" . $args['key'] . "[]";
        }

        return $args;
    }

    private function setValue(string $key)
    {
        $method = "get" . ucfirst($key);

        if (method_exists($this->entity, $method)) {
            return $this->entity->$method();
        }

        return "";
    }

    private function transformValue(string $key, $value)
    {
        if ($this->fields[$key]["type"] == EntityType::class) {
            return $this->transformEntity($key, $value);
        }

        if ($this->fields[$key]["type"] == DateType::class) {
            return $this->transformDate($key, $value);
        }

        return $value;
    }

    private function transformEntity(string $key, $value)
    {
        /** @var EntityManager $repository */
        $em = ConfigHandler::get('entityManager');
        $repository = $em->getRepository($this->fields[$key]["args"]["entry_type"] . "Repository");

        if (gettype($value) == "array") {
            $method = "add";
            $items = [];
            foreach ($value as $id) {
                $result = $repository->select("id", $this->fields[$key]["args"]["choice_label"])->find($id);
                $items[] = $result;
            }
            $value = $items;
        } else {
            $value = $repository->select("id", $this->fields[$key]["args"]["choice_label"])->find($value);
        }

        return $value;
    }

    private function transformDate(string $key, $value)
    {
        return new \DateTime($value);
    }

    private function createSelectType(SelectType $field, array $args)
    {
        $items = $args["choices"];
        $options = [];

        foreach ($items as $key => $item) {
            $type = new OptionType();
            $type->setParent($field);

            $select = "";

            if (!is_null($args["value"])) {
                if ($args["value"] == $key) {
                    $select = "selected";
                }
            }

            $type->setOptions($key, $args);
            $type->addArgs([
                "value" => $item,
                "key" => $key,
                "selected" => $select ?? "",
            ]);

            $options[] = $type->renderElement();
        }

        $field->addData("optionsHTML", implode("", $options));
    }

    private function createChoiceInput(ChoiceType $field, array $args)
    {
        $inputs = "";
        foreach ($args["choices"] as $key => $choice) {

            $name = $this->formType->getBlockPrefix() . "_" . $args["key"];

            $params = [
                "key" => $args["key"],
                "label" => $choice,
                "value" => $key,
                "placeholder" => $choice,
                "class" => "form-control",
                "type" => $field->getBlockName(),
                "name" => $name
            ];

            if($params["type"] == "checkbox") $params["name"] .= "[]";

            $inputs .= $this->render->renderHtmlElement($field, $params);
        }

        $container = new ChoiceInputType();
        $args["inputs"] = $inputs;

        $field->setHtml($this->render->renderHtmlElement($container, $args));

        return $field;
    }

}