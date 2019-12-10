<?php

namespace App\Core\Validator;


use App\Core\Database\Table;
use App\Core\Request\ParameterBag;
use App\Core\Request\Request;
use App\Core\Kernels\Kernel;

class Validator
{

    private const MIME_TYPES = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'pdf' => 'application/pdf'
    ];

    /**
     * @var ParameterBag
     */
    private $params;

    /**
     * @var Table
     */
    private $entityManager;

    /**
     * @var string[]
     */
    private $errors = [];

    /**
     * @var Table
     */
    private $pdo;

    public function __construct(ParameterBag $params)
    {
        $this->params = $params;
        $this->entityManager = Kernel::get("repository");
        $this->pdo = Kernel::get("repository");
    }

    /**
     * Vérifie que les champs sont présents dans le tableau
     *
     * @param  string[] ...$keys
     * @return Validator
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * Vérifie que le champs n'est pas vide
     *
     * @param  string[] ...$keys
     * @return Validator
     */
    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    public function length(string $key, ?int $min, ?int $max = null): self
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
     * Vérifie que l'élément est un slug
     *
     * @param  string $key
     * @return Validator
     */
    public function slug(string $key): self
    {
        $value = $this->getValue($key);
        $pattern = '/^[a-z0-9]+(-[a-z0-9]+)*$/';
        if (!is_null($value) && !preg_match($pattern, $value)) {
            $this->addError($key, 'slug');
        }
        return $this;
    }

    /**
     * Vérifie qu'une date correspond au format demandé
     *
     * @param  string $key
     * @param  string $format
     * @return Validator
     */
    public function dateTime(string $key, string $format = "Y-m-d H:i:s"): self
    {
        $value = $this->getValue($key);
        $date = \DateTime::createFromFormat($format, $value);
        $errors = \DateTime::getLastErrors();
        if ($errors['error_count'] > 0 || $errors['warning_count'] > 0 || $date === false) {
            $this->addError($key, 'datetime', [$format]);
        }
        return $this;
    }

    /**
     * Vérifie que la clef existe dans la table donnée
     *
     * @param  string $key
     * @param  string $table
     * @return Validator
     * @throws \App\Core\Exceptions\NoRecordException
     */
    public function exists(string $key, string $table): self
    {
        $value = $this->getValue($key);
        $entity = $this->entityManager->from($table)->findBy([$value]);

        if ($entity === false) {
            $this->addError($key, 'exists', [$table]);
        }
        return $this;
    }

    /**
     * Vérifie que la clef est unique dans la base de donnée
     *
     * @param  string       $key
     * @param  string|Table $table
     * @param  \PDO         $pdo
     * @param  int|null     $exclude
     * @return Validator
     */
    public function unique(string $key,string $table, ?int $exclude = null): self
    {

        $value = $this->getValue($key);
        $query = "SELECT id FROM $table WHERE $key = ?";
        $params = [$value];
        if ($exclude !== null) {
            $query .= " AND id != ?";
            $params[] = $exclude;
        }
        $statement = $this->pdo->getPdo()->prepare($query);
        $statement->execute($params);
        if ($statement->fetchColumn() !== false) {
            $this->addError($key, 'unique', [$value]);
        }
        return $this;
    }

    /**
     * Vérifie si le fichier a bien été uploadé
     *
     * @param  string $key
     * @return Validator
     */
    public function uploaded(string $key): self
    {
        $file = $this->getValue($key);
        if ($file === null || $file->getError() !== UPLOAD_ERR_OK) {
            $this->addError($key, 'uploaded');
        }
        return $this;
    }

    /**
     * Vérifie si l'email est valid
     *
     * @param  string $key
     * @return Validator
     */
    public function email(string $key): self
    {
        $value = $this->getValue($key);
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            $this->addError($key, 'email');
        }
        return $this;
    }

    public function confirm(string $key): self
    {
        $value = $this->getValue($key);
        $valueConfirm = $this->getValue($key . '_confirm');
        if ($valueConfirm !== $value) {
            $this->addError($key, 'confirm');
        }
        return $this;
    }

    /**
     * Vérifie le format de fichier
     *
     * @param  string $key
     * @param  array  $extensions
     * @return Validator
     */
    public function extension(string $key, array $extensions): self
    {
        /**
 * @var \FilesystemIterator $file 
*/
        $file = $this->getValue($key);

        if ($file !== null && $file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getType();
            $extension = mb_strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? null;
            if (!in_array($extension, $extensions) || $expectedType !== $type) {
                $this->addError($key, 'filetype', [join(',', $extensions)]);
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Récupère les erreurs
     *
     * @return ValidationError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     *  Take array of constraint and execute the validation
     *
     * @param  array $constraint
     * @return Validator
     */
    public function buildValidator(array $constraints)
    {
        foreach ($constraints as $input => $constraint){
            foreach ($constraint as $param => $value){
                switch ($param){
                case "length":
                    $this->length($input, $value["min"], isset($value["max"]) ?: null);
                    break;
                case "required":
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
                    $this->exists($input, $value["table"]);
                    break;
                case "unique":
                    $this->unique($input, $value["table"]);
                    break;
                }
            }
        }

        return $this;
    }

    /**
     * Ajoute une erreur
     *
     * @param string $key
     * @param string $rule
     * @param array  $attributes
     */
    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    private function getValue(string $key)
    {
        return $this->params->get($key);
    }
}
