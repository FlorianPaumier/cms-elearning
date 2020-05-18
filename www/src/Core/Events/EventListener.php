<?php


namespace App\Core\Events;


class EventListener
{


    /**
     * @var callable
     */
    private $callable;
    /**
     * @var int
     */
    private $priority;

    /**
     * Define if the listener can be call more the once
     * @var bool
     */
    private $once = false;

    /**
     * Stop the events parent
     * @var bool
     */
    public $stopPropagation = false;

    /**
     * How many time where the event was already call
     * @var bool
     */
    private $calls = 0;


    public function __construct(callable $callable, int $priority)
    {
        $this->callable = $callable;
        $this->priority = $priority;
    }

    public function handle(array $args){

        if($this->once && $this->calls > 0){
            return null;
        }

        $this->calls++;

        return call_user_func_array($this->callable, $args);
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**  */
    public function once(): EventListener
    {
        $this->once = true;
        return $this;
    }

    /** Allow to stop the propagation of the next events */
    public function stopPropagation()
    {
        $this->stopPropagation = true;
        return $this;
    }

    public function getCallback()
    {
        return $this->callable;
    }

}