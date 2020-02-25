<?php


namespace App\Core\Form;



use App\Core\Render\RenderView;

class FormBuilder
{

    /** @var string  */
    protected $prefix = "app";

    /** @var array */
    private $fields = [];

    /** @var string  */
    private $action = "";

    /** @var RenderView */
    private $render;

    /** @var array */
    private $form;

    /** @var array */
    private $data = [];

    /** @var array */
    private $errors = [];

    /** @var array */
    protected $inputs = [];

    public function __construct()
    {
        $this->render = new RenderView();
        define("FORM_PATH", __DIR__);
    }

    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    public function input(string $key, array $args): self
    {
        $value = $this->getValue($key);

        $args = array_merge($args,[
            "value" => $value,
            "key" => $key,
            "errors" => $this->errors,
            "prefix" => $this->prefix
        ]);

        $input[] = $key;

        $this->form[$key] = $this->render->renderHtmlElement("input", $args);
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

    public function checkbox(string $key, array $options = [])
    {
        $value = $this->getValue($key);

        $options = array_merge(
            $options, [
                "value" => $value,
                "key" => $key,
                "errors" => $this->errors,
            ]
        );

        $this->form[$key] = $this->render->renderHtmlElement("checkbox",  $options);
        return $this;
    }

    private function getInputClass(string $key, array $options = []): string
    {
        $inputClass = '';
        if (isset($this->errors[$key])) {
            $inputClass .= ' is-invalid';
        }

        if(isset($options["class"])) {
            $inputClass .= ' '.$options["class"];
        }

        return $inputClass;
    }

    private function getErrorFeedback(string $key): string
    {
        if (isset($this->errors[$key])) {
            if (is_array($this->errors[$key])) {

                $errors = array_map(
                    function ($error) {
                        return "";
                    }, $this->errors[$key]
                );
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

    public function button(string $key, array $options = [])
    {
        $options = array_merge(
            $options, [
            "key" => $key,
            "errors" => $this->errors,
            ]
        );

        $this->form[$key] = $this->render->renderHtmlElement("button", $options);
        return $this;
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

    public function getForm()
    {
        return $this->form;
    }

    public function createView()
    {
        $html =  implode(
            "", array_map(
                function ($input) {
                    return html_entity_decode($input);
                }, $this->form
            )
        );

        $form = $this->render->render(__DIR__."/form.view.php", [
            "form_view" => $html,
            "method" => "POST",
            "action"  => $this->action,
        ], true);

        return $form;
    }

    public function getInputs(){
        return $this->inputs;
    }
}
