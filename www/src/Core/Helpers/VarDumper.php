<?php

if (!function_exists('dump')) {
    /**
     * @param  $value
     * @author Nicolas Grekas <p@tchwork.com>
     */
    function dump($data, $title="", $background="#EEEEEE", $color="#000000")
    {
        //=== Style
        echo "  
    <style>
        /* Styling pre tag */
        pre {
            padding:10px 20px;
            white-space: pre-wrap;
            white-space: -moz-pre-wrap;
            white-space: -pre-wrap;
            white-space: -o-pre-wrap;
            word-wrap: break-word;
        }

        /* ===========================
        == To use with XDEBUG 
        =========================== */
        /* Source file */
        pre small:nth-child(1) {
            font-weight: bold;
            font-size: 14px;
            color: #CC0000;
        }
        pre small:nth-child(1)::after {
            content: '';
            position: relative;
            width: 100%;
            height: 20px;
            left: 0;
            display: block;
            clear: both;
        }

        /* Separator */
        pre i::after{
            content: '';
            position: relative;
            width: 100%;
            height: 15px;
            left: 0;
            display: block;
            clear: both;
            border-bottom: 1px solid grey;
        }  
    </style>
    ";
        if($_SERVER["APP_ENV"] == "dev") {

            //=== Content
            echo "<pre style='background:$background; color:$color; padding:10px 20px; border:2px inset $color'>";
            echo    "<h2>$title</h2>";
            var_dump($data);
            echo "</pre>";
        }
    }

    function output($data)
    {
        var_dump($data);
    }

    function parms($string,$data)
    {
        $indexed=$data==array_values($data);
        foreach($data as $k=>$v) {
            if(is_string($v)) { $v="'$v'";
            }
            if($indexed) { $string=preg_replace('/\?/', $v, $string, 1);
            } else { $string=str_replace(":$k", $v, $string);
            }
        }
    }
}


