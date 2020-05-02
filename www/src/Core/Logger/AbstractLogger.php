<?php


namespace App\Core\Logger;

use App\Core\Cache\CacheHandler;
use App\Core\Helpers\LogLevels;
use App\Core\Interfaces\LoggerInterface;

class AbstractLogger implements LoggerInterface
{

    /** @var self */
    private static $instance;


    private function __construct(){}

    /** Return the unique instance of the logger */
    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevels::EMERGENCY, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevels::ALERT, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevels::CRITICAL, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevels::ERROR, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevels::WARNING, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevels::NOTICE, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevels::INFO, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevels::DEBUG, $message,$context);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        $day = (new \DateTime())->setTime(0,0,0);

        $log = "[".$day->format("d-m-Y")."] - ". strtoupper($level) ." $message";

        if(is_null($logContent = CacheHandler::get($day->getTimestamp()))){
            $logContent = "";
        };

        $logContent .= "$log\n";
        CacheHandler::set($day->getTimestamp(), $logContent);
    }
}