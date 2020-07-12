<?php

namespace App\Core\Session;

use App\Core\Cache\CacheHandler;
use App\Core\Cache\ConfigHandler;
use App\Core\Request\SessionBag;

class PHPSession implements \ArrayAccess
{

    /** @var SessionBag */
    private $session;

    public function __construct()
    {
        $this->session = ConfigHandler::get("request")->getSession();
    }

    public function getSession()
    {
        return $this->session->all();
    }

    /**
     * Whether a offset exists
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param  mixed $offset <p>
     *                       An offset to check for.
     *                       </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since  5.0.0
     */
    public function offsetExists($offset)
    {
        return $this->session->exist($offset);
    }

    /**
     * Offset to retrieve
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetget.php
     * @param  mixed $offset <p>
     *                       The offset to retrieve.
     *                       </p>
     * @return mixed Can return all value types.
     * @since  5.0.0
     */
    public function offsetGet($offset)
    {
        if ($this->session->exist($offset)) {
            return $this->session->get($offset);
        }
        return false;
    }

    /**
     * Offset to set
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetset.php
     * @param  mixed $offset <p>
     *                       The offset to assign the value to.
     *                       </p>
     * @param  mixed $value  <p>
     *                       The
     *                       value
     *                       to
     *                       set.
     *                       </p>
     * @return void
     * @since  5.0.0
     */
    public function offsetSet($offset, $value)
    {
        return $this->session->set($offset, $value);
    }

    /**
     * Offset to unset
     *
     * @link   http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param  mixed $offset <p>
     *                       The offset to unset.
     *                       </p>
     * @return void
     * @since  5.0.0
     */
    public function offsetUnset($offset)
    {
        $this->session->delete($offset);
    }
}
