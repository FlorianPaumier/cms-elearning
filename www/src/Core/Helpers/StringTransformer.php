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

    public static function slugify(string $value,string $delimiter = "_"){
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);
        return $clean;
    }

    public static function toPascalCase(string $value)
    {
        $pascal = preg_replace('/[_-]/', ' $0', $value);
        $pascal = explode(" ", $pascal);
        return implode(
            "",
            array_map(function($string){
                return ucfirst($string);
            }, $pascal)
        );

    }
}