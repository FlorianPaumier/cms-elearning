<?php


namespace App\Core\Interfaces;


interface VoterInterface
{

    public function init(): array;

    public function run(): bool;
}