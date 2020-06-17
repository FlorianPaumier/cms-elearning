<?php

namespace App\Core\Security;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\database\Hydrator;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Table;
use App\Core\Request\ParameterBag;
use App\Core\Request\Request;
use App\Core\Session\PHPSession;
use App\Entity\User;

class UserManager
{
    /**
     * @var QueryBuilder
     */
    private $entityManager;

    /**
     * @var Table
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
        $this->repository = ConfigHandler::get('repository');
        $this->session = ConfigHandler::get("session");
        $this->security = CacheHandler::get("security");
    }

    /**
     * Set the user connect if he exists
     */
    public function connectUser(?string $username, ?string $password): bool
    {
        $q = $this->repository->setEntity(User::class)->findBy([
            "username" => $username,
            "password" => md5($password),
            //            "enable" => true,
        ]);

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
        //        $user = $this->repository->from('user')->findBy(["email" => $session["user"]]);
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

        if ($this->repository->from("user")->findBy(["email" => $value["email"]])) {
            return "Votre email exist déjà. Veuillez le modifier";
        }

        if ($this->repository->from("user")->insert($value)) {
            return true;
        }

        return "Une erreur estr survenue. Veuilliez réessayer. Si l'erreur persist contacter l'admin";
    }

    /**
     * Send a new password to the email if exists
     */
    public function forgetPassword(string $email)
    {
        if ($this->repository->from("user")->findBy(["email" => $value["email"]])) {
            return "un mail a été envoyé";
        }
    }

    /**
     * delete user with email
     */
    public function deleteUser(string $email)
    {
    }
}
