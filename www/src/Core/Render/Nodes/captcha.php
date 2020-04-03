<?php

header("Content-type: image/png");
imagepng($imageHandler);
imagedestroy($imageHandler);
