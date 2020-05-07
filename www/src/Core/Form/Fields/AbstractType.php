<?php


namespace App\Core\Form\Fields;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Render\RenderView;

abstract class AbstractType implements FieldsInterface
{
    /** @var RenderView */
    private $render;

    /** @var string */
    private $name;

    /** @var string */
    private $html;

    /** @var array */
    private $constraints = [];

    private $value;

    private $args = [];

    private $parent;

    protected $entity;

    private $defaultOptions = [
        "require" => true,
        'compound' => false,
        'extended' => false,
        'choice_label' => "id",
        'multiple' => false,
    ];

    public function __construct()
    {
        $this->render = new RenderView();
    }

    public function generatePrototype(string $key, FormTypeInterface $field, array $args)
    {

        $name = $args["prototype_name"] ?? "__NAME__";

        $prefix = $this->getPrefix($field);
        $field->setBlockPrefix($prefix . "[" . $name . "]");

        $builder = (new FormBuilder())->setParent(get_class($field))->setFormType($field)->setFormParentType(CollectionType::class);

        /** @var FormBuilder $form */
        $form = $field->buildForm($builder);

        $key = $args["key"];

        $view = htmlentities($form->createView(true));
        $html = '<ul id="collection_' . $key . '" data-prototype="' . $view . '" data-key="' . $name . '" class="fd-c collection container mb-5"></ul>
<button id="add-' . $key . '" data-target="collection_' . $key . '" type="button" class="add-element" data-index="0">Nouvel Element ' . $key . '</button>';

        $this->html = htmlentities($html);
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setOptions(string $key, array $args)
    {
        $this->name = $key;
        /** @var FormTypeInterface $parent */
        $parent = $this->getParent();

        $name = method_exists($parent, "getBlockPrefix") ? $parent->getBlockPrefix() . "_" . $key : "option_" . $key;

        $this->defaultOptions = array_merge($this->defaultOptions, [
            "key" => $key,
            "require" => true,
            "label" => $args["label"] ?? $key,
            "name" => $name
        ]);

        foreach ($args as $key => $arg){
            $this->defaultOptions[$key] = $arg;
        }

        $this->addArgs($this->defaultOptions);
    }

    public function getConstraintOffset(string $key)
    {
        if (key_exists($key, $this->constraints)) {
            return $this->constraints[$key];
        }
        return null;
    }

    public function addData(string $key, $value)
    {
        $this->constraints[$key] = $value;
    }

    public function addArgs(array $data)
    {
        foreach ($data as $key => $arg){
            $this->addData($key,$arg);
        }
    }

    /**
     * @return string
     */
    public function getHtml(): ?string
    {
        return $this->html ? html_entity_decode($this->html) : null;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @return AbstractType
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function renderElement()
    {
        return $this->render->renderHtmlElement($this, $this->constraints);
    }

    /**
     * @return mixed
     */
    public function getBlockType()
    {
        return "";
    }

    private function getPrefix(FormTypeInterface &$field)
    {
        $parent = $field->getParent();
        if(!is_null($parent)){
            $prefix = (new $parent)->getBlockPrefix() ;
        }

        return isset($prefix) ? $prefix."[".$field->getBlockPrefix()."]" : $field->getBlockPrefix();
    }


}