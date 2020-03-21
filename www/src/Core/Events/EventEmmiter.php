<?php


namespace App\Core\Events;


use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Exceptions\DoubleEventException;
use App\Core\Interfaces\SubscriberInterface;
use App\Core\Kernel\Kernel;

class EventEmmiter
{

    private static $_instance;

    /** @var EventListener[][] */
    private $listeners = [];

    /**
     * @return EventEmmiter
     */
    public static function getInstance(): EventEmmiter
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        if(($subscribers = CacheHandler::get("subscriber"))){
            /** @var SubscriberInterface $subscriber */
            foreach ($subscribers as $subscriber){
                if(class_exists($subscriber["class"])){
                    self::$_instance->addSubscriber(new $subscriber["class"]);
                }
            }
        }
        return self::$_instance;
    }

    /**
     * @param string $event
     * @param mixed ...$args
     */
    public function emit(string $event, ...$args)
    {
        if ($this->hasListener($event)) {
            /** @var EventListener $listener */
            foreach ($this->listeners[$event] as $listener) {
                $listener->handle($args);
                if($listener->stopPropagation){
                    break;
                }
            }
        }
    }

    /**
     * @param string $event
     * @param callable $callable
     * @param int $priority
     * @return EventListener
     * @throws DoubleEventException
     */
    public function on(string $event, callable $callable, int $priority = 0): EventListener
    {
        if (!$this->hasListener($event)) {
            $this->listeners[$event] = [];
        }

        if(!$this->callableAlreadyExist($event, $callable)){
            $listener = new EventListener($callable, $priority);
            $this->listeners[$event][] = $listener;
            $this->sortListeners($event);
            return $listener;
        }
    }

    /**
     * @param string $event
     * @param callable $callable
     * @param int $priority
     * @return EventListener
     * @throws DoubleEventException
     */
    public function once(string $event, callable $callable, int $priority = 0): EventListener
    {
        return $this->on($event, $callable, $priority)->once();
    }

    /**
     * @param string $event
     * @param callable $callable
     * @param int $priority
     */
    public function stop(string $event, callable $callable, int $priority)
    {
        if (!$this->hasListener($event)) {
            $this->listeners[$event] = [];
        }

        $this->listeners[$event][] = $callable;
    }

    public function addSubscriber(SubscriberInterface $subscriber){
        $events = $subscriber->getEvents();

        foreach ($events as $event => $args){
            $listerner = $this->on($event, [$subscriber, $args["method"]], $args["priority"] ?? 0);

            if(isset($args["once"]) && $args["once"]){
                $listerner->once();
            }

            if(isset($args["stopPropagation"]) && $args["stopPropagation"]){
                $listerner->once();
            }
        }
    }

    /**
     * @param string $event
     * @return bool
     */
    private function hasListener(string $event)
    {
        return array_key_exists($event, $this->listeners);
    }

    /**
     * @param string $event
     */
    private function sortListeners(string $event)
    {
        uasort($this->listeners[$event], function ($a,$b){
           return $a->getPriority() < $b->getPriority();
        });
    }

    /**
     * @param string $event
     * @param callable $callable
     * @return bool
     * @throws DoubleEventException
     */
    private function callableAlreadyExist(string $event, callable $callable)
    {
        foreach ($this->listeners[$event] as $listener){
            if($listener->getCallback() === $callable){
                throw new DoubleEventException();
            }
        }

        return false;
    }

    public function testEvent()
    {
    }
}