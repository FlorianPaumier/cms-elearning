<?php
namespace App\Core\Request;

class RequestHandler
{
    private static $methodAllowed = [
        "POST",
        "GET",
        "PUT",
        "DELETE"
    ];

    protected $query;
    protected $request;
    protected $attribute;
    protected $cookie;
    protected $file;
    protected $server;
    protected $session;
    protected $header;
    protected $content;
    protected $contentType;

    /**
     * Sets the parameters for this request.
     *
     * This method also re-initializes all properties.
     *
     * @param array                $query      The GET parameters
     * @param array                $request    The POST parameters
     * @param array                $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
     * @param array                $cookies    The COOKIE parameters
     * @param array                $files      The FILES parameters
     * @param array                $server     The SERVER parameters
     * @param string|resource|null $content    The raw body data
     */
    public function initialize(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->request = $request;
        $this->query = $query;
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
        $this->content = $content;
        $this->languages = null;
        $this->charsets = null;
        $this->encodings = null;
        $this->acceptableContentTypes = null;
        $this->pathInfo = null;
        $this->requestUri = null;
        $this->baseUrl = null;
        $this->basePath = null;
        $this->method = null;
        $this->format = null;
    }

    protected function createRequest(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
        array $session = []
    ) {
        $this->query = new ParameterBag($query);
        $this->request = new ParameterBag($request);
        $this->attribute = $attributes;
        $this->cookie = $cookies;
        $this->file = $files;
        $this->server = $server;
        $this->content = $content;
        $this->contentType = isset($this->server["CONTENT_TYPE"]) ?: null;
        $this->session = $session;

        return $this;
    }
}