<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class QueryBuilderTest extends TestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            "base_uri" => 'http://localhost:280'
        ]);
    }

    public function testSimpleRoute()
    {
        $response = $this->client->get("/test");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testComplexRoute()
    {
        $response = $this->client->get("/test/1");
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testErrorView()
    {
        $response = $this->client->get("/test/view");
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testWrongMethod()
    {
        $response = $this->client->post("/test");
        $this->assertEquals(405, $response->getStatusCode());
    }

    public function testForbidden()
    {
        $response = $this->client->get("/test/forbidden");
        $this->assertEquals(403, $response->getStatusCode());
    }

}
