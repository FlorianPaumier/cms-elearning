<?php

function arrayToString($array, $content = "")
{
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            return arrayToString($value, $content);
        }
        $content .= "$key => $value";
    }

    return $content;
}

?>
<div class="card">
    <?php
        echo arrayToString($parameter["trace"]);
    ?>
</div>
