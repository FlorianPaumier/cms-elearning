<?php


namespace App\Core\Render\Nodes;


use App\Core\Exceptions\ExceptionHandler;
use App\Core\Render\RenderView;

class CaptchaNode
{
    /**
     * chars to valide
     * @var array
     */
    private $captcha;

    private $range = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz";

    private $width = 400;

    private $height = 100;

    /**
     * The RGB of the background
     * @var array
     */
    private $colors;

    /**
     * the list of the font available
     * @var array
     */
    private $fonts = [];

    public function __construct()
    {
        $this->getRandFont();
    }

    /**
     * Generate a ramdom captcha
     */
    public function generate()
    {
        $length = rand(5, 7);
        
        $imageHandler = imagecreatetruecolor($this->width, $this->height);
        $bg = $this->generateImageColor($imageHandler);
        imagefill($imageHandler, 0, 0, $bg);
        $this->generateImageColor($imageHandler);

        $percent = ($this->width) / $length;

        for ($i = 0; $i < $length; $i++) {

            if ($i == $length) {
                $left = (5 + ($i * $percent));
            } else {
                $left = ($i * $percent) + 20;
            }

            $size = rand(20, 50);
            $angle = rand(-45, 45);
            $fontFile = $this->fonts[rand(1, count($this->fonts) - 1)];
            $char = $this->range[rand(0, strlen($this->range)) - 1];

            $this->captcha[] = $char;
            imagettftext(
                $imageHandler,
                $size,
                $angle,
                $left,
                rand(50, 80),
                $this->generateImageColor($imageHandler),
                $fontFile,
                $char
            );

        }
        imagefilter($imageHandler, IMG_FILTER_CONTRAST, 10);
        $this->generatePolygon($imageHandler);

        #echo RenderView::include("views.md/partials/captcha", ["image" => $imageHandler]);

        return $imageHandler;
    }

    /**
     * Get all font from the dir
     */
    private function getRandFont()
    {
        $fonts = glob(dirname(__DIR__, 2) . "/assets/fonts/*[!.]");

        foreach ($fonts as $font) {
            foreach (glob($font . "/*.ttf") as $file) {
                $this->fonts[] = $file;
            }
        }

    }

    /**
     * Generate color for the element
     * @param $image
     * @return false|int
     */
    private function generateImageColor($image)
    {
        if (is_null($this->colors)) {

            $red = rand(0, 200);
            $green = rand(0, 200);
            $blue = rand(0, 200);

            $this->colors = implode([$red, $green, $blue]);
            return imagecolorallocate($image, $red, $green, $blue);
        } else {
            return $this->color_inverse($image);
        }
    }

    /**
     * Generate a random polygon
     * @param $imageHandler
     */
    private function generatePolygon($imageHandler)
    {
        $length = rand(1, 3);

        for ($i = 0; $i < $length; $i++) {

            $points = rand(3,4);
            $pointsArray = [];
            /**
             * Create all the point for the structure
             */
            for ($y = 0; $y < $points; $y++) {
                $pointsArray[] = rand(0, $this->width);
                $pointsArray[] = rand(20, $this->height);

            }
            imagepolygon($imageHandler, $pointsArray, $points, $this->generateImageColor($imageHandler));
        }


    }

    /**
     * Return the color in the oposite range of the background
     * 0 : red
     * 1 : green
     * 2 : blue
     * @param $image
     * @return false|int
     */
    private function color_inverse($image)
    {
        if ($this->colors[0] > $this->colors[1] && $this->colors[0] > $this->colors[2]) {
            return imagecolorallocate($image, rand(0, 255), rand(0, 255), 0);
        } else {
            if ($this->colors[1] > $this->colors[0] && $this->colors[1] > $this->colors[2]) {
                return imagecolorallocate($image, rand(0, 255), 0, rand(0, 255));
            } else {
                return imagecolorallocate($image, 0, rand(0, 255), rand(0, 255));
            }
        }
    }
}