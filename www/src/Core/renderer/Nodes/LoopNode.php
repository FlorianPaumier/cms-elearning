<?php


namespace App\Core\Renderer\Nodes;


class LoopNode
{
    /** @var string */
    private $type;

    /** @var string */
    private $value;

    /** @var string */
    private $key;

    public function __construct(string $key, string $value, string $body)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function forEachAction($entry, $template)
    {

    }

    public function whileAction($entry, $template)
    {

    }
}