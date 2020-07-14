<?php


namespace App\Core\Form\Validator;


use App\Core\Cache\ConfigHandler;
use App\Core\Database\EntityManager;
use App\Core\Database\Repository\AbstractRepository;
use App\Core\Form\AbstractForm;
use App\Core\Form\Fields\ButtonType;
use App\Core\Helpers\EntityHelper;
use App\Core\Helpers\StringTransformer;
use App\Core\Interfaces\FormTypeInterface;
use App\Core\Request\ParameterBag;
use App\Core\Request\Request;

/**
 * Class Validator
 * @package App\Core\Form\Validator
 */
class Validator
{
    /**
     *
     */
    private const MIME_TYPES = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    ];

    /** @var ParameterBag */
    private $request;

    /** @var EntityManager */
    private $entityManager;

    /** @var array */
    private $errors;

    /**
     * @var array
     */
    private $form;
    /**
     * @var AbstractForm
     */
    private $parent;

    private $entity;

    /**
     * Validator constructor.
     * @param array
     * @param string $parent
     */
    public function __construct(array $form, string $parent = null)
    {
        $this->form = $form;
        $this->parent = new $parent;
        $this->entityManager = ConfigHandler::get("entityManager");
        $this->request = ConfigHandler::get("request");

        $this->buildValidator();
    }

    /**
     *  Take array of constraint and execute the validation
     * @return Validator
     */
    public function buildValidator()
    {
        foreach ($this->form as $input => $constraint) {
            if ($constraint["type"] == ButtonType::class) {
                continue;
            }
            foreach ($constraint["args"] as $param => $value) {
                switch ($param) {
                    case "length":
                        $this->length($input, $value["min"], isset($value["max"]) ?: null);
                        break;
                    case "required":
                        if (!$value) {
                            break;
                        }
                        $this->required($input);
                        break;
                    case "empty":
                        $this->notEmpty($input);
                        break;
                    case "email":
                        $this->email($input);
                        break;
                    case "extension":
                        $this->extension($input, $value);
                        break;
                    case "confirmation":
                        $this->confirm($input);
                        break;
                    case "exist":
                        $this->exists($input, $value);
                        break;
                    case "unique":
                        $this->unique($input);
                        break;
                    case "regex":
                        $this->regex($input);
                        break;
                }
            }
        }

        return $this;
    }

    /**
     * @param object|null $entity
     * @return bool
     */
    public function isValid(?object $entity): bool
    {
        $this->entity = $entity;
        return empty($this->errors);
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $values = [];

        foreach ($this->form->getInputs() as $input) {
            $values[$input] = $this->getValue($input);
        };

        return $values;
    }

    /**
     * @param string $key
     * @param int|null $min
     * @param int|null $max
     * @return $this
     */
    private function length(string $key, ?int $min, ?int $max): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);

        if (!is_null($min)
            && !is_null($max)
            && ($length < $min || $length > $max)
        ) {
            $this->addError($key, 'betweenLength', [$min, $max]);
            return $this;
        }
        if (!is_null($min)
            && $length < $min
        ) {
            $this->addError($key, 'minLength', [$min]);
            return $this;
        }
        if (!is_null($max)
            && $length > $max
        ) {
            $this->addError($key, 'maxLength', [$max]);
        }
        return $this;
    }

    /**
     * @param string ...$keys
     * @return $this
     */
    private function required(string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) && empty($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * @param string ...$keys
     * @return $this
     */
    private function notEmpty(string ...$keys)
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function email(string $key)
    {
        $value = $this->getValue($key);
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param int $input
     * @param $value
     */
    private function extension(int $input, $value)
    {
    }

    /**
     * @param string $key
     * @return $this
     */
    private function confirm(string $key)
    {
        $value = $this->getValue($key);
        $valueConfirm = $this->getValue($key . '_confirmation');
        if ($valueConfirm !== $value) {
            $this->addError($key, 'confirmation');
        }
        return $this;
    }

    /**
     * @param int $input
     * @param $table
     */
    private function exists(int $input, $table)
    {
    }

    /**
     * @param string $key
     * @param string $target
     * @param int|null $exclude
     * @return $this
     */
    private function unique(string $key)
    {
        /** @var AbstractRepository $repo */
        $repo = $this->entityManager->getRepository(EntityHelper::getClassName($this->parent->getOptions()["data_class"]) . "Repository");
        $prefix = $this->parent->getBlockPrefix();
        $index = explode($prefix . "_", $key, 2)[1];
        $value = $this->getValue($key);

        $method = "get" . ucfirst(StringTransformer::toPascalCase($index));

        if (is_callable([$this->entity, $method])) {
            $prevValue = $this->entity->$method();
            if ($prevValue === $value) {
                return $this;
            }
        }


        if ($repo->exists([$index => $value]) !== false) {
            $this->addError($index, 'unique', [$value]);
        }
        return $this;
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function getValue(string $key)
    {
        return $this->request->get($key);
    }

    public function getErrors()
    {
        $errors = $this->errors;
        $this->errors = [];
        return $errors;
    }

    /**
     * Ajoute une erreur
     *
     * @param string $key
     * @param string $rule
     * @param array $attributes
     */
    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = (new ValidationError($key, $rule, $attributes))->__toString();
    }

    /**
     * @param int $input
     */
    private function regex(int $input)
    {

    }

}
