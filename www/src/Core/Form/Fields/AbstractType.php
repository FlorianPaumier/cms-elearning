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
    private $constraints;

    private $value;

    private $parent;

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

        $this->inputs[] = $form->getInputs();

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

        $options = [
            "require" => true,
            "label" => $key,
            "name" => $parent->getBlockPrefix()."_".$key,
            'compound' => false,
        ];

        $this->constraints = array_merge($options, $args);
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

    public function renderElement(array $args = [])
    {
        return $this->render->renderHtmlElement($this, $args);
    }
}