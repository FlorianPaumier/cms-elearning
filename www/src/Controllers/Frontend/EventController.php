<?php


namespace App\Controllers\Frontend;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;

class EventController extends BaseController
{

    public function index(Request $request)
    {
        return $this->render("frontend/events/calendar");
    }
}