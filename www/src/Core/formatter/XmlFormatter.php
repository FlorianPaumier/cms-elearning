<?php
namespace App\Core\Formatter;

use App\Core\database\Hydrator;
use DOMDocument;
use Prophecy\Exception\Doubler\ClassNotFoundException;

class XmlFormatter implements FormatterInterface
{
    private $data;

    public function setData($data)
    {
        $this->data = $data;
    }

    public function serialize()
    {
        return $this->xml_encode($this->data);
    }

    public function deserialize(string $class)
    {
        if(!class_exists($class)){
            throw new ClassNotFoundException();
        }
        $array = $this->xml_decode($this->data);
        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }

    private function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
        if (is_null($DOMDocument)) {
            $DOMDocument =new DOMDocument;
            $DOMDocument->formatOutput = true;
            $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
            echo $DOMDocument->saveXML();
        }
        else {
            // To cope with embedded objects
            if (is_object($mixed)) {
                $mixed = get_object_vars($mixed);
            }
            if (is_array($mixed)) {
                foreach ($mixed as $index => $mixedElement) {
                    if (is_int($index)) {
                        if ($index === 0) {
                            $node = $domElement;
                        }
                        else {
                            $node = $DOMDocument->createElement($domElement->tagName);
                            $domElement->parentNode->appendChild($node);
                        }
                    }
                    else {
                        $plural = $DOMDocument->createElement($index);
                        $domElement->appendChild($plural);
                        $node = $plural;
                        if (!(rtrim($index, 's') === $index)) {
                            $singular = $DOMDocument->createElement(rtrim($index, 's'));
                            $plural->appendChild($singular);
                            $node = $singular;
                        }
                    }

                    $this->xml_encode($mixedElement, $node, $DOMDocument);
                }
            }
            else {
                $mixed = is_bool($mixed) ? ($mixed ? 'true' : 'false') : $mixed;
                $domElement->appendChild($DOMDocument->createTextNode($mixed));
            }
        }
    }

    private function xml_decode(): array
    {
        //TODO
    }
}