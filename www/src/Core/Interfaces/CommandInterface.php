<?php
namespace App\Core\Helpers;

interface CommandInterface
{
    public function __construct();
    public function execute();
}