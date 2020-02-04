<?php

header("Content-type: image/png");
require "./CaptchaNode.php";

$image = (new CaptchaNode())->generate();
imagepng($image);
