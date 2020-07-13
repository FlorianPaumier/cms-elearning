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
        $this->repository = new UserRepository();
        $this->session = ConfigHandler::get("session");
        $this->security = CacheHandler::get("security");

    }

    /**
     * Set the user connect if he exists
     */
    public function connectUser(?string $username, ?string $password): bool
    {
        /** @var User $q */
        $q = $this->repository->where("username = :username")->orWhere("email = :email")
            ->setParameters([
                "username" => $username,
                "email" => $username,
            ])->fetch();

        $response = false;

        if (!empty($q) && !is_null($q)) {
            if (!password_verify($password, $q->getPassword())) {
                return false;
            }
            $response = true;
            $this->session->offsetSet("app.user", [
                "user" => $q->getEmail(),
                "roles" => $q->getRoles(),
                "timestamp" => time() + 2 * 60 * 60,
            ]);
        }


//        dump($this->session->getSession());
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
        dump($this->session->getSession());

        if ($this->session->offsetGet("app.user")) {

            if (!$this->session->offsetGet("app.user")["timestamp"] < time()) {
                $this->disconnectUser();
            } else {
                return true;
            }
        }

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

        try {
            $this->entityManager->persist($user)->flush();
        }catch (\Exception $e){
            return "Une erreur est survenue. Veuilliez réessayer. Si l'erreur persist contacter l'admin";
        }

        return $user;
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
                ->setBody("<a href='" . $server['HTTP_HOST'] . "/reset-token?token=" . $user->getForgetPasswordToken() . "'>Reset Password</a>")
                ->setDest($email)
                ->setContentType("text/html");
            if ($mailer->send($message)) {
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

    public function confirmRegister(string $email)
    {
        if ($this->entityManager->from("user")->exists(["email" => $email])) {

            $user = $this->entityManager->setEntity(User::class)->findBy(["email" => $email]);
            $user->setconfirmationToken(bin2hex(random_bytes(32)));

            $server = ConfigHandler::get("request")->getServer();
            $mailer = new MailerHandler();
            $message = (new MailerMessage())
                ->setSubjet("Confirmation de l'inscription")
                ->setBody("<a href='" . $server['HTTP_HOST'] . "/confirmation=" . $user->getconfirmationToken() . "'>Confirmation de votre inscription</a>")
                ->setDest($email)
                ->setContentType("text/html");
            if ($mailer->send($message)) {
                return "un mail a été envoyé";
            }

            return "Un problème est survenue lors de l'envoi";
        }
    }
}