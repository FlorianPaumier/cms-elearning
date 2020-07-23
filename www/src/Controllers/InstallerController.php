<?php


namespace App\Controllers;


use App\Core\Cache\ConfigHandler;
use App\Core\Exception\NoRecordException;
use App\Core\Formatter\Serializer;
use App\Core\Interfaces\BaseController;
use App\Core\Mailer\MailerHandler;
use App\Core\Render\RenderView;
use App\Core\Request\Request;
use App\Entity\SiteConfiguration;
use App\Entity\User;
use App\Form\InstallerAdminForm;
use App\Form\InstallerConfigurationForm;
use App\Form\InstallerDatabaseForm;
use App\Repository\NewsletterEmailRepository;
use App\Repository\SiteConfigurationRepository;
use App\Repository\UserRepository;
use Exception;
use PDO;

/**
 * Class InstallerController
 * @package App\Controllers
 */
class InstallerController extends BaseController
{

    /**
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function index(): RenderView
    {
        /*if(file_exists(ROOT_PATH."/app/config/config.yml")) {
            $this->redirect->redirectToRoute("app_home");
        }*/

        return $this->renderer->render("installer/index",[
            "title" => "Installation"
        ]);
    }

    /**
     * @param Request $request
     * @param SiteConfigurationRepository $repository
     * @return RenderView|string|string[]|null
     * @throws NoRecordException
     */
    public function configuration(Request $request, SiteConfigurationRepository $repository, UserRepository $user): RenderView
    {
        /*if($user->findAll()){
            $this->redirect->redirectTo('/');
        }*/

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
            $this->redirect->redirectToRoute("installer_configuration_admin");
        }

        return $this->render("installer/configuration", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            "title" => "Configuration du site"
        ]);
    }

    /**
     * @param Request $request
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function database(Request $request ) {

        /*if(file_exists(ROOT_PATH."/app/config/config.yml")) {
            $this->redirect->redirectToRoute("app_home");
        }*/

        $form = $this->createForm(InstallerDatabaseForm::class);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $databaseInfo = [];

            foreach ($request->getRequest()->all() as $key => $value) {
                $index = explode("admin_configuration_", $key, 2)[1];

                if (in_array($index, [
                    "server_database_driver",
                    "server_database_host",
                    "server_database_port",
                    "server_database_dbname",
                    "server_database_username",
                    "server_database_password",
                    "server_database_charset",
                    "server_database_prefix"
                ]))
                {
                    $databaseInfo[$index] = $value;
                }
            }

            $serializer = new Serializer();
            $config = ["env" => "dev",
                "database" => [
                    "driver" => $databaseInfo["server_database_driver"],
                    "host" => $databaseInfo["server_database_host"],
                    "port" => $databaseInfo["server_database_port"],
                    "dbname" => $databaseInfo["server_database_dbname"],
                    "username" => $databaseInfo["server_database_username"],
                    "password" => $databaseInfo["server_database_password"],
                    "charset" => $databaseInfo["server_database_charset"],
                    "prefix" => $databaseInfo["server_database_prefix"]
                ],
                "mailer" => [
                    "transport" => "smtp",
                    "encryption" => "ssl",
                    "spool" => ["type" => "memory"]
                ]
            ];

            $this->initDatabase(
                $config["database"]["dbname"],
                $config["database"]["password"],
                $config["database"]["host"],
                $config["database"]["username"],
                $config["database"]["port"]===""?5432:$config["database"]["port"]
            );

            $config = $serializer->serialize($config, "yaml");

            file_put_contents(ROOT_PATH . "/app/config/config.yml", $config);

            $this->redirect->redirectToRoute("installer_configuration_migration");
        }
        return $this->render("installer/database", [
            "form" => $form->createView(),
            "errors" => $form->getErrorFeedback(),
            "title" => "Configuration de la base de donnée"
        ]);
    }

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function createAdmin(Request $request, UserRepository $repository)
    {
        /*if($repository->findAll()) {
            $this->redirect->redirectTo('/');
        }*/

        $user = new User();

        $form = $this->createForm(InstallerAdminForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user->setRoles(["ROLE_ADMIN"]);

            $password = $user->getPassword();
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->redirect->redirectToRoute("installer_configuration_success");
        }

        return $this->renderer->render("installer/register",
            [
                "errors" => $form->getErrorFeedback(),
                "form" => $form->createView(),
                "title" => 'Création d\'un compte admin'
            ]
        );
    }

    /**
     * @param MailerHandler $handler
     * @return false|string
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function testMailer(MailerHandler $handler){
        header("Status: 200", 0,200);
        return json_encode(["result" => $handler->sendTest()]);
    }

    /**
     * @return RenderView|string|string[]|null
     * @throws Exception
     */
    public function success(UserRepository $repository) {
        /*if($repository->findAll()) {
            $this->redirect->redirectTo('/');
        }*/

        return $this->renderer->render("installer/success",[
            "title" => "Configuration success"
        ]);
    }

    /**
     * @param string $dbName
     * @param string $password
     * @param string $host
     * @param string $username
     * @param int $port
     * @throws Exception
     */
    public function initDatabase(string $dbName,string $password,string $host,string $username, int $port = 5432) {
        $pdo = new PDO("pgsql:dbname=postgres;port=$port;host=$host", $username, $password);
        $pdo->prepare("CREATE DATABASE $dbName")->execute();
        $pdo = null;

        $pdo = new PDO("pgsql:dbname=$dbName;port=$port;host=$host", $username, $password);
        $pdo->prepare("CREATE TABLE IF NOT EXISTS patch_list(id SERIAL PRIMARY KEY NOT NULL, table_name varchar(255), current_version int);")->execute();
        $pdo = null;

    }

}