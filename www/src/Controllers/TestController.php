<?php


namespace App\Controllers;


use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;

class TestController extends BaseController
{
    const array = [
        "Key" => "value",
        "Key2" => "value",
        "Key3" => "value",
        "array" => ["key" => "value"]
    ];

    public function simpleRouting()
    {
        return "Ok";
    }

    public function complexTeouting($id)
    {
        return $id;
    }

    public function forbidden($id)
    {
        return $id;
    }

    public function errorView()
    {
        $this->renderer->render("homee");
    }

    public function toJson()
    {
        $serializer = new Serializer();
        $json = $serializer->serialize(self::array, "json");
        dump($json);
        $array = $serializer->deserialize($json, "json");
        dump($array);
    }

    public function toIni()
    {
        $serializer = new Serializer();
        $ini = $serializer->serialize(self::array, "ini");
        dump($ini);
        $array = $serializer->deserialize($ini, "ini");
        dump($array);
    }

    public function toXml()
    {
        $serializer = new Serializer();
        $xml = $serializer->serialize(self::array, "xml");
        dump($xml, "Encode");
        $array = $serializer->deserialize($xml, "xml");
        dump($array);
    }

    public function toYaml()
    {
        $serializer = new Serializer();
        $yaml = $serializer->serialize(self::array, "yaml");
        dump($yaml);
        $array = $serializer->deserialize($yaml, "yaml");
        dump($array);
    }
}