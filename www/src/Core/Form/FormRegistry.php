<?php


namespace App\Core\Form;


class FormRegistry
{

    private $registry;

    private $types;

    public function getType(string $name){
        if (!isset($this->types[$name])) {
            $type = null;

            foreach ($this->extensions as $extension) {
                if ($extension->hasType($name)) {
                    $type = $extension->getType($name);
                    break;
                }
            }

            if (!$type) {
                // Support fully-qualified class names
                if (!class_exists($name)) {
                    throw new \Exception(sprintf('Could not load type "%s": class does not exist.', $name));
                }
                if (!is_subclass_of($name, 'Symfony\Component\Form\FormTypeInterface')) {
                    throw new \Exception(sprintf('Could not load type "%s": class does not implement "Symfony\Component\Form\FormTypeInterface".', $name));
                }

                $type = new $name();
            }

            $this->types[$name] = $this->resolveType($type);
        }

        return $this->types[$name];
    }

}