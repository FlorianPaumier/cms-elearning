<?php


namespace App\Controllers;


use App\Core\Cache\ConfigHandler;
use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Request\Request;
use App\Entity\SiteConfiguration;
use App\Entity\User;
use App\Form\InstallerAdminForm;
use App\Form\InstallerConfigurationForm;
use App\Form\InstallerDatabaseForm;
use App\Repository\SiteConfigurationRepository;
use PDO;

class InstallerController extends BaseController
{
    public function index()
    {
        return $this->renderer->render("installer/index",[
            "title" => "Installation"
        ]);
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

        $form = $this->createForm(InstallerConfigurationForm::class, $config);
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

                file_put_contents(ROOT_PATH."/app/config/config.yml",$config);
            }
            $this->entityManager->flush();
            $this->redirect->redirectToRoute("installer_configuration_database");
        }

        return $this->render("installer/configuration", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }

    public function database(Request $request, SiteConfigurationRepository $repository ) {

        /** @var SiteConfiguration[] $configurations */
        $configurations = $repository->findAll();

        $config = [];

        foreach ($configurations as $configuration) {
            $index = $configuration->getKey();
            $config[$index] = $configuration->getValue();
        }

        $form = $this->createForm(InstallerDatabaseForm::class, $config);
        $form->setData($config);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $databaseInfo = [];

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

                if (in_array($index, [
                    "server_database_driver",
                    "server_database_host",
                    "server_database_port",
                    "server_database_dbname",
                    "server_database_username",
                    "server_database_password",
                    "server_database_charset",
                ])
                ) {
                    if ($siteConfig->getValue() !== $value) {
                    }
                    $databaseInfo[$index] = $value;
                }

                $serializer = new Serializer();
                $config = $serializer->deserialize(file_get_contents(ROOT_PATH . "/app/config/config.yml"), "yaml");
                $config["database"]["driver"] = $databaseInfo["server_database_driver"];
                $config["database"]["host"] = $databaseInfo["server_database_host"];
                $config["database"]["port"] = $databaseInfo["server_database_port"];
                $config["database"]["dbname"] = $databaseInfo["server_database_dbname"];
                $config["database"]["username"] = $databaseInfo["server_database_username"];
                $config["database"]["password"] = $databaseInfo["server_database_password"];
                $config["database"]["charset"] = $databaseInfo["server_database_charset"];
                $config["database"]["prefix"] = $databaseInfo["server_database_prefix"];
                $config = $serializer->serialize($config, "yaml");

                file_put_contents(ROOT_PATH . "/app/config/config.yml", $config);

                $this->entityManager->persist($siteConfig);
            }

            $this->entityManager->flush();
            $this->initDatabase($databaseInfo["server_database_dbname"]);
        }
        return $this->render("installer/database", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }

    public function createAdmin(Request $request)
    {
        $user = new user();

        $form = $this->createForm(InstallerAdminForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setRoles(["ROLE_ADMIN"]);

            $password = $user->getPassword();
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->redirect->redirectToRoute("installer_configuration_success");
        } else {
            $this->session->set("app.flash", ["error" => $form->getErrors()]);
        }

        return $this->renderer->render("installer/register",
            [
                "form" => $form->createView(),
            ]
        );
    }

    public function testMailer(MailerHandler $handler){
        header("Status: 200", 0,200);
        return json_encode(["result" => $handler->sendTest()]);
    }

    public function success() {

        $siteConfig = (new SiteConfiguration())
            ->setKey('install')
            ->setValue(1);
        $this->entityManager->persist($siteConfig);
        $this->entityManager->flush();

        return $this->renderer->render("installer/success",[
            "title" => "Configuration success"
        ]);
    }

    public function initDatabase($dbName) {
        $sql = "CREATE DATABASE $dbName";

        ConfigHandler::get("entityManager")->getPdo()->exec($sql);

        $this->redirect->redirectToRoute("installer_configuration_admin");
    }

}