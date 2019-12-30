<?php
namespace App\Core\Request;

class Request extends RequestHandler
{

    /**
     * @param array                $query      The GET parameters
     * @param array                $request    The POST parameters
     * @param array                $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array                $cookies    The COOKIE parameters
     * @param array                $files      The FILES parameters
     * @param array                $server     The SERVER parameters
     * @param string|resource|null $content    The raw body data
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Creates a new request with values from PHP's super globals.
     *
     * @return Request
     */
    public static function createFromGlobals()
    {
        $request = (new Request())->createRequest($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

        /*if (0 === strpos($request->contentType, 'application/x-www-form-urlencoded')
            && \in_array(strtoupper($request->getMethod()), ['GET', 'PUT', 'DELETE', 'PATCH'])
        ) {
            parse_str($request->getContent(), $data);
            $request->request = new ParameterBag($data);
        }*/

        return $request;
    }
    
    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param  mixed $query
     * @return Request
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return ParameterBag
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param  mixed $request
     * @return Request
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param  mixed $server
     * @return Request
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param  mixed $session
     * @return Request
     */
    public function setSession($session)
    {
        $this->session = $session;
        return $this;
    }


    public function getMethod()
    {
        return $this->server["REQUEST_METHOD"] ?: "GET";
    }
}