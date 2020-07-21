<?php

use App\Core\Exceptions\AbsctractException;
use App\Core\Exceptions\NotFoundAbsctractException;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class RoutingTest extends TestCase
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
        $this->expectException(Exception::class);
        $this->expectExceptionCode(404);
        $response = $this->client->get("/test/view");
    }

    public function testWrongMethod()
    {
        $this->expectExceptionCode(405);
        $this->expectException(Exception::class);
        $response = $this->client->post("/test");
    }

    public function testForbidden()
    {
        $this->expectExceptionCode(403);
        $this->expectException(Exception::class);
        $response = $this->client->get("/test/forbidden");
    }

}
