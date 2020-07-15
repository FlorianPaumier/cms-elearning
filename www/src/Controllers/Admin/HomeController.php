<?php

namespace App\Controllers\Admin;


use App\Core\Interfaces\BaseController;
use App\Core\Request\Request;
use App\Entity\SiteConfiguration;
use App\Form\ConfigurationForm;
use App\Repository\SiteConfigurationRepository;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->renderer->render(ROOT_PATH . "/public/views/admin/home");
    }

    public function configuration(Request $request, SiteConfigurationRepository $repository)
    {

        /** @var SiteConfiguration[] $configurations */
        $configurations = $repository->findAll();

        $config = [];

        foreach ($configurations as $configuration){
            $index = $configuration->getKey();
            $config[$index] = $configuration->getValue();
        }

        $form = $this->createForm(ConfigurationForm::class, $config);
        $form->setData($config);
        $form->handleRequest($request);

        if ($form->isValid()) {

            foreach ($request->getRequest()->all() as $key => $value) {
                $index = explode("admin_configuration_", $key,2)[1];

                $siteConfig = $repository->findOneBy(["key" => $index]);

                if (is_null($siteConfig)){
                    $siteConfig = (new SiteConfiguration())
                        ->setKey($index)
                        ->setValue($value);
                }else{
                    $siteConfig->setValue($value);
                }
                $this->entityManager->persist($siteConfig);
            }
            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_config");
        }

        return $this->render("admin/configuration", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }
}