<?php


namespace App\Core\Request;


class SessionBag implements \ArrayAccess
{
    /**
     * @var array
     */
    private $session;

    public function __construct(array &$session)
    {
        $this->session = $session;
    }

    /**
     * Return the Session array
     * @return array
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return key_exists($offset, $this->session);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (preg_match("/\[\]/", $offset)) {
            $offset = preg_replace("/\[\]/", "", $offset);
        }
        return $this->offsetExists($offset) ? $this->session[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->session[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if($this->offsetExists($offset)) unset($this->session[$offset]);
    }

}