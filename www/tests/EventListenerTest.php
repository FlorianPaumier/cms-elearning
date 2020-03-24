<?php


namespace Tests\Framework\Database;

use App\Core\Events\EventEmmiter;
use App\Core\Exceptions\DoubleEventException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument\ArgumentsWildcard;
use Prophecy\Argument\Token\AnyValuesToken;
use stdClass;

class EventListenerTest extends TestCase
{

    private $emmiter;

    protected function setUp(): void
    {
        if(!defined("ROOT_PATH")){
            define("ROOT_PATH", dirname(__DIR__));
        }

        if(!defined("FORM_PATH")){
            define("FORM_PATH", ROOT_PATH."/src/Core/Form");
        }

        if(!defined("CONFIG_PATH")){
            define("CONFIG_PATH",ROOT_PATH."/app/config");
        }

        if(!defined("CACHE_PATH")){
            define("CACHE_PATH",ROOT_PATH."/app/cache");
        }

        if(!defined("ROUTING_PATH")){
            define("ROUTING_PATH",ROOT_PATH."/app/routing");
        }

        if(!defined("VIEW_PATH")){
            define("VIEW_PATH", ROOT_PATH."/public/views.md");
        }

        $_SERVER["APP_ENV"] = "dev";
        $_SERVER["APP_DEBUG"] = true;

        $this->emmiter = EventEmmiter::getInstance();
    }

    public function testIsSingleton(){
        $instance = EventEmmiter::getInstance();
        self::assertInstanceOf(EventEmmiter::class, $instance);

        $singleton = EventEmmiter::getInstance();
        self::assertEquals($instance, $singleton);
    }

    public function testListenerTest()
    {
        $calls = [];

        $this->emmiter->on("error.500", function () use (&$calls) {
            $calls[] = 2;
        });

        self::assertEquals(0, count($calls));

        $this->emmiter->emit("error.500");

        self::assertEquals(1, count($calls));
    }

    public function testPriorityTrigger()
    {
        $calls = [];

        $this->emmiter->on("error.500", function () use (&$calls) {
            $calls[] = 2;
        }, 1);

        $this->emmiter->on("error.500", function () use (&$calls) {
            $calls[] = 4;
        }, 2);

        $this->emmiter->emit("error.500");
        self::assertEquals([4,2], $calls);

    }

    public function testTriggerOnce(){
        $calls = 0;
        $emmiter = EventEmmiter::getInstance();

        $emmiter->once("error.500", function () use (&$calls) {
            $calls++;
        });

        $emmiter->emit("error.500");
        $emmiter->emit("error.500");

        self::assertEquals(1, $calls);
    }

    public function testStopPropagation(){
        $calls = [];
        $emmiter = EventEmmiter::getInstance();


        $this->emmiter->on("error.500", function () use (&$calls) {
            $calls[] = 2;
        })->stopPropagation();

        $this->emmiter->on("error.500", function () use (&$calls) {
            $calls[] = 4;
        });

        $emmiter->emit("error.500");

        self::assertEquals([2], $calls);
    }

    public function testPreventTwiceEvent(){
        self::expectException(DoubleEventException::class);

        $this->emmiter->on("error.500", [$this->emmiter, "testEvent"]);
        $this->emmiter->on("error.500",[$this->emmiter, "testEvent"]);

    }

}