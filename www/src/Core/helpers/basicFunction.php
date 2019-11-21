<?php

/**
 * Set the the content of a directory into a array
 *
 * @param string $dir
 * @param string $ext
 * @return array
 */
function dirToArray(string $dir,string $ext = "yml") {
    $files = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $files[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $extFile = explode(".", $value, 2)[1];
                if($extFile == "$ext" && $extFile !== "$ext.dist")
                    $files[] = $value;
            }
        }
    }

    return $files;
}