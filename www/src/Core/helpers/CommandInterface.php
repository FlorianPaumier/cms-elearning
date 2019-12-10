<?php
namespace App\Core\Interfaces;

interface CommandInterface
{
    public function __construct();
    public function execute();
}