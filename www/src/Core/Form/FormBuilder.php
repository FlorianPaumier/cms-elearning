<?php


namespace App\Core\Form;



use App\Core\Interfaces\FormTypeInterface;
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

    /**
     * FormBuilder constructor.
     */
    public function __construct()
    {
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

    /**
     * @param string $key
     * @param array $args
     * @return $this
     * @throws \Exception
     */
    public function input(string $key, array $args): self
    {
        $value = $this->getValue($key);

        $args = array_merge($args,[
            "value" => $value,
            "key" => $key,
            "errors" => $this->errors,
            "prefix" => $this->prefix
        ]);

        if(empty($args["type"])){
            $args["type"] = "text";
        }

        $input[] = $key;

        $this->form[$key] = $this->render->renderHtmlElement("input", $args);
        return $this;
    }

    /**
     * @param string $key
     * @return mixed|string|null
     */
    private function getValue(string $key)
    {
        if(is_null($this->data)){
            return null;
        }

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

    /**
     * @param string $key
     * @param array $options
     * @return $this
     * @throws \Exception
     */
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

        $input[] = $key;

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

    /**
     * @param string $key
     * @return string
     */
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

    /**
     * @param string $key
     * @param array $args
     * @return $this
     * @throws \Exception
     */
    public function textarea(string $key, array $args)
    {
        $value = $this->getValue($key);

        $args = array_merge(
            $args, [
                "value" => $value,
                "key" => $key,
                "errors" => $this->errors,
            ]
        );

        $input[] = $key;

        $this->form[$key] = $this->render->renderHtmlElement("textarea",  $args);
        return $this;
    }

    /**
     * @param string $key
     * @param array $options
     * @return $this
     * @throws \Exception
     */
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

    /**
     * @param string $key
     * @param array $args
     * @return $this
     * @throws \Exception
     */
    public function select(string $key, array $args = [])
    {
        $value = $this->getValue($key);

        $args = array_merge(
            $args, [
                "value" => $value,
                "key" => $key,
                "errors" => $this->errors,
            ]
        );

        $input[] = $key;

        $this->form[$key] = $this->render->renderHtmlElement("select", $args);
        return $this;
    }

    /**
     * @param string $key
     * @param string $class
     * @param array $args
     * @return $this
     * @throws \Exception
     */
    public function collection(string $key, string $class, array $args){
        if(!class_exists($class)) throw new \Exception("Class $class not found", 404);


        /** @var FormTypeInterface $form */
        $form = (new $class)->buildForm();

        $view = htmlentities($form->createView(true));
        $html = '<ul id="collection_'.$key.'" data-prototype="'.$view.'" class="fd-c collection container mb-5"></ul>
<button id="add-'.$key.'" data-target="collection_'.$key.'" type="button" class="add-element" data-index="0">Nouvel Element '.$key.'</button>';

        $this->inputs[] = $form->getInputs();

        $this->form[$key] = htmlentities($html);
        return $this;
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
     * @return RenderView|string|string[]|null
     */
    public function createView(bool $prototype = false)
    {
        $html =  implode(
            "", array_map(
                function ($input) {
                    return html_entity_decode($input);
                }, $this->form
            )
        );

        if($prototype){
            return $html;
        }

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
