<?php

namespace Tests;

use App\Core\Exceptions\ExceptionHandler;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ExceptionHandlerTest
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://localhost:280',
            // You can set any number of default request options.
            'timeout' => 2.0,
        ]);
    }

    public function testSuccessRequest()
    {
        $response = $this->client->get("/test/success");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testBadRequestHandler()
    {
        $response = $this->client->get("/test/param/hello");
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testCrsfInvalidHandler()
    {

    }

    public function testForbiddenHandler()
    {
        #TODO
        $response = $this->client->get("/test/forbidden");
        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testInvalidMethodHandler()
    {
        $response = $this->client->get("/test/method");
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testNotFoundHandler()
    {
        $response = $this->client->get("/test/view");
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testToManyRequestHandler()
    {
        #TODO
    }

    public function testServerErrorHandler()
    {
        #TODO
    }
}
