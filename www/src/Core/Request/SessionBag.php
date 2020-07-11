<?php


namespace App\Core\Request;


class SessionBag
{
    private $session;

    public function __construct(array &$session)
    {
        $this->session = $session;
    }

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
        return $this->exist($key) ? $this->session[$key] : null;
    }

    /**
     * Return the Session array
     * @return array
     */
    public function all()
    {
        return $this->session;
    }

    /** Add or update entry in session */
    public function set(string $key, $value)
    {
        return $this->session[$key] = $value;
    }

    /** If key exist delete entry */
    public function delete(string $key){
        if($this->exist($key)) unset($this->session[$key]);
    }

    /** Search if key exist in session */
    public function exist(string $key)
    {
        return key_exists($key, $this->session);
    }
}