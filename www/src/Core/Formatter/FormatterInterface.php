<?php
namespace App\Core\Formatter;

interface FormatterInterface
{
    //TODO: Test Unitaiire
    public function setData($data);
    public function serialize();
    public function deserialize(string $class);
}