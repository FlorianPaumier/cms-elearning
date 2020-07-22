<?php

namespace App\Core\Database;

use App\Core\Cache\ConfigHandler;
use App\Core\Collections\ArrayCollection;
use App\Core\Database\Repository\AbstractRepository;
use App\Core\Formatter\Serializer;
use App\Core\Helpers\EntityHelper;
use App\Core\Helpers\StringTransformer;

/**
 * Transforme un tableau en objet en utilisant les setters
 */
abstract class Hydrator
{
    /**
     * @var bool
     */
    static $relations = false;

    /**
     * @var bool
     */
    static $recursif = false;

    /** @var array */
    static $parents = [];

    /** @var int */
    static $count = 0;


    /**
     * Transforme un tableau en objet en utilisant les setters
     *
     * @param array $array
     * @param  $object
     * @return mixed
     */
    public static function hydrate($array, $object)
    {
        if (empty($array)) {
            return $array;
        }

        if (is_string($object)) {
            $instance = new $object();
        } else {
            $instance = $object;
        }
        $i = 0;

        $serializer = new Serializer();

        foreach ($array as $key => $value) {
            if (self::$relations) {
                $key = str_replace(EntityHelper::getClass($instance) . "_", "", $key);
            }

            $method = self::getSetter($key);

            if (!method_exists($instance, $method) || !is_callable([$instance, $method])) {
                continue;
            }

            $type = self::getParameterType($instance, $method);

            /** If the proccess is not in a children hydration request and the type is not null  */
            if (!is_null($type) && !self::isRecursif()) {
                $class = $type->getName();

                /**
                 * If we have en class in parameters function and the result from sql is a int
                 * Perfom a find on the repository of the class and had parent to avoid a infinit loop
                 */
                if (!($value instanceof $class)) {
                    if (gettype($value) == "integer") {
                        self::$parents[] = get_class($instance);
                        self::$recursif = true;
                        ++self::$count;
                        /** @var AbstractRepository $repo */
                        $repo = ConfigHandler::get("entityManager")->getRepository($class . "Repository");
                        $value = $repo->find($value);
                    }
                }

                self::$recursif = false;
                ConfigHandler::get("entityManager")->setEntity(get_class($instance));

            } else {
                /**
                 * If we are in a children hydration request
                 */
                if (!is_null($type) && self::isRecursif()) {
                    $class = $type->getName();
                    ++self::$count;

                    /** if class isn't a datetime and the class isn't already class to avoid infinit loop and no more then 6 call to increase performance */
                    if ($class !== \DateTime::class && !in_array($class, self::$parents) && self::$count < 6) {

                        /** @var AbstractRepository $repo */
                        $repo = ConfigHandler::get("entityManager")->getRepository($class . "Repository");
                        $value = $repo->find($value);

                        self::$parents[] = $class;
                    } elseif ($class !== \DateTime::class) {
                        $value = (new $class())->setId($value);
                    }
                }
            }

            if (self::isTypeArray($instance, $method)) {
                $value = $serializer->deserialize($value, "json");
            }

            if (!is_null($type) && ($type == "datetime" || $type->getName() == "DateTime")) {
                $value = new \DateTime($value);
            }

            if (is_null($value)) {
                continue;
            }

            $instance->$method($value);

            $i++;
        }

        return $instance;
    }

    /**
     * Hydrate object after a join request
     * @param array $array
     * @param $object
     * @return array
     * @throws \ReflectionException
     */
    public static function hydrateRelation(array $array, $object)
    {

        if (is_string($object)) {
            $instance = new $object();
        } else {
            $instance = $object;
        }

        $data = [];

        $principalClass = StringTransformer::PascalCaseToSnakeCase(EntityHelper::getClassName($object));
        $principalKey = $principalClass . "_";

        /**
         * First we get the main entity information
         */
        foreach ($array as $row) {
            foreach ($row as $key => $value) {
                if (is_null($value)) {
                    continue;
                }

                if (strpos($key, $principalKey) !== false) {
                    $propertie = str_replace($principalKey, "", $key);
                    $id = $principalKey . $row[$principalKey . "id"];

                    if (!key_exists($id, $data)) {
                        if (is_string($object)) {
                            $instance = new $object();
                        } else {
                            $instance = $object;
                        }

                        $data[$id] = $instance;
                    }

                    $method = self::getSetter($propertie);

                    if (!is_callable([$instance, $method])) {
                        continue;
                    }

                    $type = self::getParameterType($data[$id], $method);

                    if (is_null($type)) {
                        $data[$id]->$method($value);
                    }elseif ($type->getName() !== "DateTime"){
                        $class = EntityHelper::getClassName($type->getName());
                        $repo = ConfigHandler::get("entityManager")->getRepository($class . "Repository");
                        $value = $repo->find($value);
                        $data[$id]->$method($value);
                    }
                }
            }
        }

        $reflection = new \ReflectionClass($object);
        $properties = $reflection->getProperties();

        /**
         * Second we get all information from the join table and insert it into main entity
         */
        foreach ($properties as $propertie) {
            $add = self::getSetter($propertie->getName(), true);

            if (method_exists($instance, $add)) {
                $addType = self::getParameterType($instance, $add);
                if (!is_null($addType)) {
                    $typeName = $addType->getName();
                    $joinClass = StringTransformer::PascalCaseToSnakeCase(EntityHelper::getClassName($typeName));
                    dump($joinClass);
                    foreach ($data as $key => $object) {
                        foreach ($array as $row) {
                            $currentInstance = new $typeName();
                            foreach ($row as $fieldName => $value) {
                                $parentId = $joinClass . "_" . $principalClass . "_id";
                                if (strpos($fieldName, $joinClass . "_") !== false) {
                                    $propertie = str_replace($joinClass . "_", "", $fieldName);
                                    $method = self::getSetter($propertie);
                                    if (method_exists($currentInstance, $method)) {
                                        $type = self::getParameterType($currentInstance, $method);
                                        if (is_null($type)) {
                                            $currentInstance->$method($value);
                                        }
                                    }
                                }
                            }

                            if (!is_null($row[$parentId]) && $row[$parentId] == $data[$principalKey . $row[$parentId]]->getId()) {
                                $data[$principalKey . $row[$parentId]] = $data[$principalKey . $row[$parentId]]->$add($currentInstance);
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Get data from object to perfom a sql query
     * @param object $object
     * @return array
     * @throws \ReflectionException
     */
    public static function getData(object $object): array
    {

        $serializer = new Serializer();

        $params = [];

        $class = new \ReflectionClass(get_class($object));

        /** @var \ReflectionProperty $property */
        foreach ($class->getProperties() as $property) {
            $name = $property->getName();

            $key = StringTransformer::slugify($name);
            $method = "get" . StringTransformer::toPascalCase($name);

            if (!method_exists($object, $method)) {
                $method = "is" . ucfirst($name);
                if (!method_exists($object, $method)) {
                    ConfigHandler::get("eventEmmiter")->emit("erreur.404", "method don't exist for $name in " . get_class($object));
                }
            }

            $value = $object->$method();

            if (!is_null($value)) {
                if ($value instanceof \DateTime) {
                    $value = $value->format("Y-m-d H:m:i");
                }

                if (gettype($value) == "object") {
                    if (get_class($value) == ArrayCollection::class) {
                        continue;
                    }

                    $key .= "_id";
                    $value = $value->getId();
                } elseif (gettype($value) == "boolean") {
                    $value = (int)$value;
                }

                if (gettype($value) == "array") {
                    $value = $serializer->serialize($value, 'json');
                }
                $params[$key] = $value;
            }
        };

        return $params;

    }

    /**
     * @return bool
     */
    public static function isRecursif(): bool
    {
        return self::$recursif;
    }

    /**
     * Return type of the parameter in the called method
     * @param object $instance
     * @param string $method
     * @return \ReflectionClass|string|null
     * @throws \ReflectionException
     */
    private static function getParameterType(object $instance, string $method)
    {
        $reflection = new \ReflectionMethod($instance, $method);

        /** @var \ReflectionParameter $parameter */
        return !is_null($reflection->getParameters()[0]) ? $reflection->getParameters()[0]->getClass() : null;
    }

    /**
     * @param object $instance
     * @param string $method
     * @return bool|null
     * @throws \ReflectionException
     */
    private static function isTypeArray(object $instance, string $method)
    {
        $reflection = new \ReflectionMethod($instance, $method);
        return !is_null($reflection->getParameters()[0]) ? $reflection->getParameters()[0]->isArray() : null;
    }

    /**
     * format function set
     * @param string $fieldName
     * @return string
     */
    private static function getSetter(string $fieldName, bool $collection = false): string
    {
        if ($collection) {
            $fieldName = mb_substr($fieldName, 0, -1);
            return 'add' . self::getProperty($fieldName);
        }

        return 'set' . self::getProperty($fieldName);
    }

    /**
     * Format the field Name
     * @param string $fieldName
     * @return string
     */
    private static function getProperty(string $fieldName): string
    {
        $field = join('', array_map('ucfirst', explode('_', $fieldName)));

        if (preg_match('/_id/m', $fieldName)) {
            $field = str_replace("Id", "", $field);
        }

        return $field;
    }
}
