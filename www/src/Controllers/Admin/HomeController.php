<?php

namespace App\Controllers\Admin;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Repository\SiteConfigurationRepository;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->renderer->render(ROOT_PATH . "/public/views/admin/home");
    }

    public function configuration(Request $request)
    {
        $configs = $this->entityManager->getRepository(SiteConfigurationRepository::class)->findAll();

        foreach ($request->getRequest()->all() as $key => $value){
            dump([$key, $value]);
            foreach ($configs as $config){

            }
        }

        return $this->render("admin/configuration", [
            "configurations" => $configs
        ]);
    }
}