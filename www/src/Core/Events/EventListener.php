<?php


namespace App\Core\Events;


class EventListener
{

    /**
     * @var callable
     */
    private $callable;

    /**
     * order to call the different function
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


    /**
     * EventListener constructor.
     * @param callable $callable
     * @param int $priority
     */
    public function __construct(callable $callable, int $priority)
    {
        $this->callable = $callable;
        $this->priority = $priority;
    }

    /**
     * If the method need to be called once, don't call the method
     * Call the function given and inject parameters and increment counter
     * @param array $args
     * @return mixed|null
     */
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

    /**
     * Set the function to be called just one time
     */
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

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callable;
    }

}