<?php


namespace App\Core\Security;


use App\Entity\User;

class RolesManager
{

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var array
     */
    private $container = [];


    public function __construct()
    {
        $this->userManager = new UserManager();
    }

    public function can(string $key): bool
    {
        $user = $this->userManager->getUser();

        if (!key_exists($key, $this->container["allow"]) && !key_exists($key, $this->container["deny"])) {
            return true;
        }

        $allow = $this->offsetExist($this->container["allow"], $key, $user);
        $deny = $this->offsetExist($this->container["deny"], $key, $user);

        if ($allow && !$deny) {
            return false;
        }

        if (!$allow && $deny) {
            return false;
        }

        return true;
    }

    public function allowing(string $key, $roles)
    {
        $this->container["allow"][$key] = $roles;
    }

    public function denied(string $key, $roles)
    {
        $this->container["deny"][$key] = $roles;
    }

    public static function routeAllowed(array $route, string $key)
    {
        $userManager = new UserManager();
        $user = $userManager->getUser();

        $role = "";

        if (!empty($user)) {
            $role = $user["roles"];
        }

        if ($role == "ROLE_ADMIN" || in_array("ROLE_ADMIN", $role)) {
            return true;
        }

        if (key_exists($key, $route)) {
            $roles = $route[$key];

            if (is_string($roles)) {
                return $roles == $role;
            } else {
                $hasRole = false;
                foreach ($role as $value) {
                    if (in_array($value, $roles)) {
                        $hasRole = true;
                        break;
                    }
                }
                return $hasRole;
            }
        }

        return true;
    }

    private function offsetExist(array $container, string $key, $value): bool
    {
        if (key_exists($key, $container)) {
            $roles = $container[$key];

            if (gettype($roles) === "string") {
                return $roles == $value;
            } else {
                $role = array_search($value, $roles);
                return $role !== false;
            }
        }

        return true;
    }


}