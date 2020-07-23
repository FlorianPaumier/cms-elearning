<?php

namespace App\Controllers\Admin;


use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Request\Request;
use App\Core\Router\Router;
use App\Entity\SiteConfiguration;
use App\Entity\User;
use App\Form\ConfigurationAdminForm;
use App\Form\ConfigurationDatabaseForm;
use App\Form\ConfigurationForm;
use App\Form\UserRegisterForm;
use App\Repository\SiteConfigurationRepository;
use function Symfony\Component\String\u;

class HomeController extends BaseController
{
    public function index()
    {
        return $this->renderer->render("/admin/dashboard/dashboard");
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
                    $databaseInfo[$index] = $value;
                }

                $this->entityManager->persist($siteConfig);
            }

            $serializer = new Serializer();
            $config = $serializer->deserialize(file_get_contents(ROOT_PATH . "/app/config/config.yml"), "yaml");
            $config["env"] = in_array( 1, $request->getRequest()->get("admin_configuration_production")) ? "prod" : "dev";
            $config["maintenance"] = in_array( 1, $request->getRequest()->get("admin_configuration_maintenance")) ? true : false;
            $config["mailer"]["host"] = $emailInfo["server_mail_host"];
            $config["mailer"]["port"] = $emailInfo["server_mail_port"];
            $config["mailer"]["username"] = $emailInfo["server_mail_identifiant"];
            $config["mailer"]["password"] = $emailInfo["server_mail_password"];
            $config = $serializer->serialize($config, "yaml");
            file_put_contents(ROOT_PATH . "/app/config/config.yml", $config);

            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_config");
        }

        return $this->render("admin/configuration", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }

    public function generateSiteMap(Serializer $serializer, Router $router)
    {
        $routes = CacheHandler::get("routing");

        $map = array_map(function ($key, $route) use ($router) {
            if (!key_exists("roles", $route) && strpos($route["path"], "test") === false) {
                $route["key"] = $key;
                return $this->getPath($route, $router);
            }
        }, array_keys($routes), $routes);

        $map = array_unique($map);

        $sitemap = $serializer->serialize(["sitemap" => $map], "xml");
        file_put_contents(ROOT_PATH . "/public/assets/sitemap.xml", $sitemap, EXTR_OVERWRITE);

        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . basename("/assets/sitemap.xml") . "\"");

        readfile(ROOT_PATH . "/public/assets/sitemap.xml");
        exit();
    }

    public function database(Request $request, SiteConfigurationRepository $repository)
    {

        /** @var SiteConfiguration[] $configurations */
        $configurations = $repository->findAll();

        $config = [];

        foreach ($configurations as $configuration) {
            $index = $configuration->getKey();
            $config[$index] = $configuration->getValue();
        }

        $form = $this->createForm(ConfigurationDatabaseForm::class, $config);
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

                $this->entityManager->persist($siteConfig);
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
            $config = $serializer->serialize($config, "yaml");

            file_put_contents(ROOT_PATH . "/app/config/config.yml", $config);

            $this->entityManager->flush();
            $this->redirect->redirectToRoute("admin_config_database");
        }
        return $this->render("admin/database", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
        ]);
    }

    public function createAdmin(Request $request)
    {
        $user = new user();

        $form = $this->createForm(ConfigurationAdminForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setRoles(["ROLE_ADMIN"]);

            $password = $user->getPassword();
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->redirect->redirectToRoute("app_user_login");
        }

        return $this->renderer->render("/configuration/register",
            [
                "errors" => $form->getErrorFeedback(),
                "form" => $form->createView(),
            ]
        );
    }

    public function testMailer(MailerHandler $handler)
    {
        header("Status: 200", 0, 200);
        return json_encode(["result" => $handler->sendTest()]);
    }

    private function getPath(array $route, Router $router)
    {

        if (strpos($route["path"], '{') !== false && !key_exists("entity", $route)) {
            return null;
        }

        if (!$route["entity"]) {
            return $route["path"];
        }

        $repo = $this->entityManager->getRepository($route["entity"] . "Repository");

        $items = $repo->select("id")->findAll();

        $paths = [];
        if (is_null($items)) {
            return $paths;
        }
        foreach ($items as $item) {
            $paths[$route["key"]][] = $router->getPath($route["key"], $item->getId());
        }
        return $paths;
    }
}