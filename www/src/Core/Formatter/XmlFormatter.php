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
        $data = ["root" => $this->data];
        return $this->xml_encode($data);
    }

    public function deserialize(string $class = null)
    {
        if(!is_null($class) && !class_exists($class)){
            throw new ClassNotFoundException();
        }

        $array = $this->xml_decode($this->data);

        if(is_null($class)){
            return $array;
        }

        $object = new $class();
        return Hydrator::hydrate($array, $object);
    }

    private function xml_encode($mixed, $domElement=null, $DOMDocument=null) {
        if (is_null($DOMDocument)) {
            $DOMDocument = new DOMDocument;
            $DOMDocument->formatOutput = true;
            $this->xml_encode($mixed, $DOMDocument, $DOMDocument);
            return $DOMDocument->saveXML();
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

    private function xml_decode($data)
    {
		$ob= simplexml_load_string($data);
		$json  = json_encode($ob);
		return json_decode($json, true);
    }
}