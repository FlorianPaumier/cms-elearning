<?php

namespace App\Core\Security;

use App\Core\database\Hydrator;
use App\Core\Database\QueryBuilder;
use App\Core\Database\Table;
use App\Core\Entity\User;
use App\Core\Exception\ForbiddenException;
use App\Core\Request\Request;
use App\Core\Session\PHPSession;
use App\Core\Kernel\Kernel;

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
        $this->entityManager = Kernel::get("entityManager");
        $this->repository = Kernel::get('repository');
        $this->session  = Kernel::get("session");
        $this->security  = Kernel::get("security");

    }

    /**
     * Set the user connect if he exists
     */
    public function connectUser(?string $username, ?string $password): bool
    {
        $q = $this->repository->from("user")->findBy([
            "username" => $username,
            "password" => md5($password),
            "enable" => true,
            ]);

        $response = false;

        if($q !== false){
            $response = true;
            $this->session->set("app.user", [
                "user" => $q["email"],
                "roles" => $q["roles"],
                "timestamp" => time() + 2*60*60,
            ]);
        }
        return $response;
    }

    /**
     * Logout the current user
     */
    public function disconnectUser()
    {
        $this->session->delete("app.user");
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

        if($this->session->get("app.user")["timestamp"] < time()){
            $this->disconnectUser();
        }else{
            return true;
        }

        return false;

    }

    public function getUser(){
        $session = $this->session->offsetGet("app.user");
        $user = $this->repository->from('user')->findBy(["email" => $session["user"]]);
        return $this->repository->hydrate(new User(), $user);
    }
    /**
     * Test if the current user had the right roles to this request
     */
    public function isAllowed(array $route)
    {
        foreach ($this->security["firewall"]["access_control"] as $firewall) {
            $reg = str_replace("/", "\/",$firewall["path"]);

            if(preg_match("/${reg}/", $route["path"])){
                if(!in_array("IS_AUTHENTICATED_ANONYMOUSLY",$firewall["roles"])){
                    if(!$this->isConnected()){
                        return false;
                    }else{
                        $haveRoles = false;
                        foreach ($this->getUser()->getRoles() as $roles){
                            if(in_array($roles, $firewall["roles"])){
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

        if($this->repository->from("user")->findBy(["email" => $value["email"]])){
            return "Votre email exist déjà. Veuillez le modifier";
        }

        if($this->repository->from("user")->insert($value)){
            return true;
        }

        return "Une erreur estr survenue. Veuilliez réessayer. Si l'erreur persist contacter l'admin";
    }

    /**
     * Send a new password to the email if exists
     */
    public function forgetPassword(string $email)
    {
    }
}