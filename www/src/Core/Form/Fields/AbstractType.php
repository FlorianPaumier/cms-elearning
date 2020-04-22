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

    public function generatePrototype(FormTypeInterface $field)
    {
        /** @var FormBuilder $form */
        $form = (new $field)->buildForm(new FormBuilder());

        $name = $args["prototype_name"] ?? "__NAME__";
        $form->setBlockPrefix($form->getBlockPrefix() . "[" . $name . "]");

        $args["name"] = $form->getBlockPrefix();

        $key = "";
        $view = htmlentities($form->createView(true));
        $html = '<ul id="collection_' . $key . '" data-prototype="' . $view . '" data-key="' . $name . '" class="fd-c collection container mb-5"></ul>
<button id="add-' . $key . '" data-target="collection_' . $key . '" type="button" class="add-element" data-index="0">Nouvel Element ' . $key . '</button>';

        $this->form[$key] = htmlentities($html);
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

        $this->defaultOptions = array_merge($this->defaultOptions, [
            "key" => $key,
            "require" => true,
            "label" => $args["label"] ?? $key,
            "name" => method_exists($parent, "getBlockPrefix") ? $parent->getBlockPrefix() . "_" . $key : "option_" . $key,
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
    public function getBlockPrefix()
    {
    }


}