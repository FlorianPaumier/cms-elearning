<?php

namespace App\Core\Formatter;

class Serializer
{

    public function serialize($data, string $format)
    {
        $formatter = $this->formatter($format, $data);
        return $formatter->serialize();
    }

    private function formatter(string $type, $data)
    {
        switch ($type) {
            case "json":
                $formatter = new JsonFormatter();
                $formatter->setData($data);
                break;
            case "yaml":
                $formatter = new YamlFormatter();
                $formatter->setData($data);
                break;
            case "xml":
                $formatter = new XmlFormatter();
                $formatter->setData($data);
                break;
            case "ini":
                $formatter = new IniFormatter();
                $formatter->setData($data);
                break;
        }

        if(!isset($formatter)){
            throw new \Exception();
        }

        return $formatter;
    }

    public function deserialize($data, string $class, string $format)
    {
        $formatter = $this->formatter($format, $data);
        return $formatter->serialize();
    }
}