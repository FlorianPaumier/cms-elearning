<?php
namespace App\Controllers;

use App\Core\Interfaces\BaseController;
use App\Services\FluxRSSHandler;

class FluxRSSController extends BaseController
{
    public function index()
    {
        $serializer = new FluxRSSHandler();

        for ($i = 0; $i <= 10; $i++){
            $serializer->setItem("title $i", "data $i", "footer $i");
        }

        $rss = $serializer->render();

        dump($rss);
    }
}