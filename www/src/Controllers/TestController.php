<?php


namespace App\Controllers;


use App\Core\Cache\ConfigHandler;
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

    public function complexRouting($id)
    {
        return $id;
    }

    public function forbidden($id)
    {
        ConfigHandler::get("eventEmmiter")->emit("error.403");
        return $id;
    }

    public function errorView()
    {
        return $this->render("homee");
    }

    public function toJson()
    {
        $serializer = new Serializer();
        $json = $serializer->serialize(self::array, "json");
        $array = $serializer->deserialize($json, "json");
        return $array;
    }

    public function toIni()
    {
        $serializer = new Serializer();
        $ini = $serializer->serialize(self::array, "ini");
        $array = $serializer->deserialize($ini, "ini");
        return $array;
    }

    public function toXml()
    {
        $serializer = new Serializer();
        $xml = $serializer->serialize(self::array, "xml");
        $array = $serializer->deserialize($xml, "xml");
        return $array;
    }

    public function toYaml()
    {
        $serializer = new Serializer();
        $yaml = $serializer->serialize(self::array, "yaml");
        $array = $serializer->deserialize($yaml, "yaml");
        return $array;
    }

    public function testPathFunction(){
        return $this->render("test/path");
    }
}