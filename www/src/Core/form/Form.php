<?php

namespace App\Core\Form;

use App\Core\Kernel\Kernel;
use App\Core\Renderer\RenderView;

class Form
{
    /**
     * @var FormType
     */
    private $formType;

    /**
     * @var array|object
     */
    private $data;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $form;

    /**
     * @var string
     */
    private $prefix;

    /** @var RenderView $render */
    private $render;

    /**
     * @var array
     */
    private $fields;

    public function __construct()
    {
        $this->data = [];
        $this->errors = [];
        $this->render = new RenderView();
    }

    public function buildForm(string $form)
    {
        $this->formType = new $form();
        return $this;
    }

    public function input(string $key, string $label, bool $require = true, array $options = [])
    {
        $value = $this->getValue($key);
        $type = $key === "password" || $key === "password_confirm" ? "password" : "text";
        $required = $require ? "required" : null;

        $options = array_merge($options, [
            "value" => $value,
            "label" => $label,
            "key" => $key,
            "type" => $type,
            "required" => $required,
            "errors" => $this->errors,
        ]);

        $this->form[$key] = $this->render->getHtmlElement("input",  $options);
        return $this;
    }

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

    private function getInputClass(string $key, array $options = []): string
    {
        $inputClass = '';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }

        if(isset($options["class"])){
            $inputClass .= ' '.$options["class"];
        }

        return $inputClass;
    }

    private function getErrorFeedback(string $key): string
    {
        if (isset($this->errors[$key])) {
            if (is_array($this->errors[$key])) {

                $errors = array_map(function($error) {
                    return "";
                },$this->errors[$key]);
                $error = implode("", $errors);
            } else {
                $error = $this->errors[$key];
            }
            return '';
        }
        return '';
    }

    public function textarea(string $key, string $label, bool $require = true)
    {
        $value = $this->getValue($key);
        $required = $require ? "required" : null;
        $this->form[$key] = "";
        return $this;
    }

    public function button(string $key, string $label,array $options = []){
        $options = array_merge($options, [
            "key" => $key,
            "label" => $label,
            "errors" => $this->errors,
        ]);

        $this->form[$key] = $this->render->getHtmlElement("button", $options);
    }

    public function select(string $key, string $label, array $options = [], bool $require = true, bool $multiple = false)
    {
        $optionsHTML = [];
        $value = $this->getValue($key);
        foreach ($options as $k => $v) {
            $selected = in_array($k, $value) ? " selected" : "";
            $optionsHTML[] = "";
        }
        $optionsHTML = implode('', $optionsHTML);

        $multi = null;
        $required = $require ? "required" : null;

        if ($multiple) {
            $multi = "multiple";
        }

        $this->form[$key] = "";
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function addError(string $key, string $error)
    {
        $this->errors[$key] = $error;
    }

    public function removeError(string $key)
    {
        unset($this->errors[$key]);
    }

    public function getForm(){
        return $this->form;
    }

    public function createView()
    {
        /** @var Form $form */
        $fields = $this->formType->buildForm();
        $view = "<form method='post' action=''>";

        foreach ($fields->getForm() as $field){
            $view .= html_entity_decode($field);
        }
        $view .= "</form>";
        return $view;
    }
}