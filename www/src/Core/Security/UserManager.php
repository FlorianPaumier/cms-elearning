<?php

namespace App\Core\Security;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\database\Hydrator;
use App\Core\Database\QueryBuilder;
use App\Core\Database\EntityManager;
use App\Core\Mailer\MailerHandler;
use App\Core\Mailer\MailerMessage;
use App\Core\Request\ParameterBag;
use App\Core\Request\Request;
use App\Core\Session\PHPSession;
use App\Entity\User;
use App\Repository\UserRepository;

class UserManager
{
    /**
     * @var QueryBuilder
     */
    private $entityManager;

    /**
     * @var EntityManager
     */
    private $repository;

    /**
     * @var PHPSession
     */
    private $session;

    private $security;

    public function __construct()
    {
        $this->entityManager = ConfigHandler::get("entityManager");
        $this->entityManager =  new UserRepository();
        $this->session = ConfigHandler::get("session");
        $this->security = CacheHandler::get("security");

    }

    /**
     * Set the user connect if he exists
     */
    public function connectUser(?string $username, ?string $password): bool
    {
        $q = $this->entityManager->setEntity(User::class)->findBy([
            "username" => $username,
            "password" => md5($password),
            //            "enable" => true,
        ]);

//        dump(empty($q));
        $response = false;

        if (!empty($q)) {
            $response = true;
            $this->session->offsetSet("app.user", [
                "user" => $q->getEmail(),
                "roles" => $q->getRoles(),
                "timestamp" => time() + 2 * 60 * 60,
            ]);
        }

        return $response;
    }

    /**
     * Logout the current user
     */
    public function disconnectUser()
    {
        $this->session->offsetUnset("app.user");
    }

    /**
     * Test if the current user is connected
     */
    public function isConnected()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        /*if (!isset($_SESSION['auth'])) {
        throw new ForbiddenException();
        }*/

        if ($this->session->offsetGet("app.user")["timestamp"] < time()) {
            $this->disconnectUser();
        } else {
            return true;
        }

        dump("Login");
        dump($this->session->get("app.user"));

        return false;
    }

    /**
     * Get the current user if login
     * @return mixed
     * @throws \App\Core\Exception\NoRecordException
     */
    public function getUser()
    {
        $session = $this->session->offsetGet("app.user");
        //        $user = $this->entityManager->from('user')->findBy(["email" => $session["user"]]);
        return $session;
    }

    /**
     * Test if the current user had the right roles to this request
     */
    public function isAllowed(array $route)
    {
        foreach ($this->security["firewall"]["access_control"] as $firewall) {
            $reg = str_replace("/", "\/", $firewall["path"]);

            if (preg_match("/${reg}/", $route["path"])) {
                if (!in_array("IS_AUTHENTICATED_ANONYMOUSLY", $firewall["roles"])) {
                    if (!$this->isConnected()) {
                        return false;
                    } else {
                        $haveRoles = false;
                        foreach ($this->getUser()->getRoles() as $roles) {
                            if (in_array($roles, $firewall["roles"])) {
                                $haveRoles = true;
                            };
                        }
                        return $haveRoles;
                    }
                }
            }
        };

        return true;
    }

    public function updateUser()
    {
    }

    /**
     * Create a new user
     */
    public function createUser(Request $query)
    {
        $user = Hydrator::hydrate($query->getRequest()->all(), User::class);

        $value = $user->objectToSql();

        $error = [];

        if ($this->entityManager->findBy(["email" => $user->getEmail()])) {
            return "Votre email exist déjà. Veuillez le modifier";
        }

        $this->entityManager->persist($user)->flush();
die;
        return "Une erreur est survenue. Veuilliez réessayer. Si l'erreur persist contacter l'admin";
    }

    /**
     * Send a new password to the email if exists
     */
    public function forgetPassword(string $email)
    {
        if ($this->entityManager->from("user")->exists(["email" => $email])) {

            $user = $this->entityManager->setEntity(User::class)->findBy(["email" => $email]);
            $user->setForgetPasswordToken(bin2hex(random_bytes(32)));

            $server = ConfigHandler::get("request")->getServer();
            $mailer = new MailerHandler();
            $message = (new MailerMessage())
                ->setSubjet("Forget Password")
                ->setBody("<a href='".$server['HTTP_HOST']."/reset-token?token=".$user->getForgetPasswordToken()."'>Reset Password</a>")
                ->setDest($email)
                ->setContentType("text/html")
                ;
                if($mailer->send($message)){
                    return "un mail a été envoyé";
                }

                return "Un problème est survenue lors de l'envoi";
        }

        return "Aucun utilisateur ne correspond à cette email";
    }

    /**
     * delete user with email
     */
    public function deleteUser(string $email)
    {
    }
}