<?php


namespace App\Core\Helpers;


abstract class StringTransformer
{

    public static function PascalCaseToSnakeCase(string $value)
    {
        $snake = preg_replace('/[A-Z]/', '_$0', $value);
        $snake = strtolower($snake);
        $snake = ltrim($snake, '_');
        return $snake;
    }
}