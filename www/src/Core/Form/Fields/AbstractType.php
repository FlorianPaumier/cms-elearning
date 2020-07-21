<?php


namespace App\Core\Form\Fields;


use App\Core\Form\FormBuilder;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Render\RenderView;

/**
 * Class AbstractType
 * @package App\Core\Form\Fields
 */
abstract class AbstractType implements FieldsInterface
{

    #region Field
    /** @var RenderView */
    private $render;

    /** @var string */
    private $name;

    /** @var string */
    protected $html;

    /** @var array */
    private $constraints = [];

    /**
     * @var
     */
    private $value;

    /**
     * @var array
     */
    private $args = [];

    /**
     * @var
     */
    private $parent;

    /**
     * @var
     */
    protected $entity;

    /**
     * @var array
     */
    private $defaultOptions = [
        "require" => true,
        'compound' => false,
        'extended' => false,
        'choice_label' => "id",
        'multiple' => false,
        'placeholder' => "",
        "class" => "",
    ];

    #endregion

    /**
     * AbstractType constructor.
     */
    public function __construct()
    {
        $this->render = new RenderView();
    }

    /**
     * @deprecated
     * @param string $key
     * @param FormTypeInterface $field
     * @param array $args
     * @throws \Exception
     */
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

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set options for the field and overwrite the default one
     * @param string $key
     * @param array $args
     */
    public function setOptions(string $key, array $args)
    {
        $this->name = $key;
        /** @var FormTypeInterface $parent */
        $parent = $this->getParent();

        if(method_exists($parent, "getBlockPrefix")){
            if(is_null($parent->getBlockPrefix()) || empty($parent->getBlockPrefix())){
                $parent->setBlockPrefix();
            }

            $name = $parent->getBlockPrefix() ."_" .$key;
        }else {
            $name = "option_" . $key;
        }

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

    /**
     * @deprecated
     * @param string $key
     * @return mixed|null
     */
    public function getConstraintOffset(string $key)
    {
        if (key_exists($key, $this->constraints)) {
            return $this->constraints[$key];
        }
        return null;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function addData(string $key, $value)
    {
        $this->constraints[$key] = $value;
    }

    /**
     * @param array $data
     */
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

    /**
     * Render the element to get the html
     * @return string
     * @throws \Exception
     */
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

    /**
     * @param FormTypeInterface $field
     * @return string
     */
    private function getPrefix(FormTypeInterface &$field)
    {
        $parent = $field->getParent();
        if(!is_null($parent)){
            $prefix = (new $parent)->getBlockPrefix() ;
        }

        return isset($prefix) ? $prefix."[".$field->getBlockPrefix()."]" : $field->getBlockPrefix();
    }


}