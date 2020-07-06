<?php


namespace App\Core\Request;


class SessionBag
{

    /**
     * Return the data in the request if the key exist
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        if (preg_match("/\[\]/", $key)) {
            $key = preg_replace("/\[\]/", "", $key);
        }
        return $this->exist($key) ? $_SESSION[$key] : null;
    }

    /**
     * Return the Session array
     * @return array
     */
    public function all()
    {
        return $_SESSION;
    }

    /** Add or update entry in session */
    public function set(string $key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /** If key exist delete entry */
    public function delete(string $key){
        if($this->exist($key)) unset($_SESSION[$key]);
    }

    /** Search if key exist in session */
    public function exist(string $key)
    {
        return key_exists($key, $_SESSION);
    }
}