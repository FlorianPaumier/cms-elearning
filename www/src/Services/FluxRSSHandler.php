<?php
namespace App\Services;

use App\Core\Formatter\Serializer;

class FluxRSSHandler
{
    private $formatter;
    private $data;

    public function __construct()
    {
        $this->formatter = (new Serializer());
    }

    public function setItem($title, $data, $footer){
        $this->data[] = [
            "title" => $title,
            "data" => $data,
            "footer" => $footer
        ];
    }

    public function render(){
        return $this->formatter->serialize($this->data, "xml");
    }
}