<?php

namespace App\Controllers\Admin;


use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
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

        foreach ($configurations as $configuration) {
            $index = $configuration->getKey();
            $config[$index] = $configuration->getValue();
        }

        $form = $this->createForm(ConfigurationForm::class, $config);
        $form->setData($config);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $emailInfo = [];

            foreach ($request->getRequest()->all() as $key => $value) {
                $index = explode("admin_configuration_", $key, 2)[1];

                $siteConfig = $repository->findOneBy(["key" => $index]);

                if (is_null($siteConfig)) {
                    $siteConfig = (new SiteConfiguration())
                        ->setKey($index)
                        ->setValue($value);
                } else {
                    $siteConfig->setValue($value);
                }

                if (in_array($index, ["server_mail_host", "server_mail_port", "server_mail_identifiant", "server_mail_password"])) {
                    if ($siteConfig->getValue() !== $value) {
                    }
                    $emailInfo[$index] = $value;
                }

                $this->entityManager->persist($siteConfig);
            }

            if (count($emailInfo) >= 3) {
                $serializer = new Serializer();
                $config = $serializer->deserialize(file_get_contents(ROOT_PATH."/app/config/config.yml"), "yaml");
                $config["mailer"]["host"] = $emailInfo["server_mail_host"];
                $config["mailer"]["port"] = $emailInfo["server_mail_port"];
                $config["mailer"]["username"] = $emailInfo["server_mail_identifiant"];
                $config["mailer"]["password"] = $emailInfo["server_mail_password"];
                $config = $serializer->serialize($config, "yaml");
                dump($config);
                file_put_contents(ROOT_PATH."/app/config/config.yml",$config);
            }
            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_config");
        }

        return $this->render("admin/configuration", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }

    public function testMailer(MailerHandler $handler){
        header("Status: 200", 0,200);
        return json_encode(["result" => $handler->sendTest()]);
    }
}