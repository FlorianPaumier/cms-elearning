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

    public static function slugify(string $value, string $delimiter = "_"){
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $value, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode($delimiter, $ret);
    }

    public static function toPascalCase(string $value)
    {
        $pascal = preg_replace('/[_-]/', ' ', $value);
        $pascal = explode(" ", $pascal);
        return implode(
            "",
            array_map(function($string){
                return ucfirst($string);
            }, $pascal)
        );

    }
}