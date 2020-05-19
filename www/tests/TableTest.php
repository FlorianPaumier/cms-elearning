<?php
namespace Tests;

use App\Core\Database\Table;
use App\Entity\User;
use PDO;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase{

    /**
     * @var Table
     */
    private $Table;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        $pdo->exec('CREATE Table user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(255),
            password VARCHAR(255)
        )');

        $this->Table = new Table($pdo);
        $this->Table->from("user");
    }


    public function testFind()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->Table->setEntity(User::class);
        $test = $this->Table->find(1);
        $this->assertInstanceOf(User::class, $test);
        $this->assertEquals('a1', $test->getUsername());
    }

    public function testFindList()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->assertEquals(['1' => 'a1', '2' => 'a2'], $this->Table->findList());
    }

    public function testFindAll()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->Table->setEntity(User::class);
        $categories = $this->Table->findAll();
        $this->assertCount(2, $categories);
        $this->assertEquals('a1', $categories[0]->getUsername());
        $this->assertEquals('a2', $categories[1]->getUsername());
    }

    public function testFindBy()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->setEntity(User::class);
        $category = $this->Table->findBy(['username' => 'a1']);
        $this->assertEquals(2, count($category));
    }

    public function testExists()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->assertTrue($this->Table->exists(["username" => "a1"]));
        $this->Table->from("user");
        $this->assertTrue($this->Table->exists(["id" => 2]));
        $this->Table->from("user");
        $this->assertFalse($this->Table->exists(["id" => 100000]));
    }

    public function testCount()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->assertEquals(3, $this->Table->count());
    }

    public function testCountWithQuery()
    {
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
        $this->Table->select("username")->where("username = :username")->setParam("username", "a2");
        $this->assertEquals(1, $this->Table->count());
    }

    public function testInsert()
    {
        $this->Table->setEntity(User::class);
        $this->Table->insert(['username' => 'Salut', 'password' => 'demo']);

        $post = $this->Table->find(1);
        $this->assertEquals('Salut', $post->getUsername());
        $this->assertEquals('demo', $post->getPassword());
    }

    public function testUpdate()
    {
        $user = (new User())->setUsername("Salut")->setPassword("demo");
        $this->Table->setEntity(User::class);
        $this->Table->persist($user)->flush();
        $insert = $this->Table->setEntity(User::class)->find(1);
        $this->assertEquals('Salut', $insert->getUsername());
        $this->assertEquals('demo', $insert->getPassword());
        $insert->setPassword("hello");
        $this->Table->persist($insert)->flush();
        $this->Table->setEntity(User::class);
        $update = $this->Table->find($insert->getId());
        $this->assertEquals('Salut', $update->getUsername());
        $this->assertEquals('hello', $update->getPassword());
    }

    public function testDelete()
    {
        $this->Table->insert(['username' => 'Salut', 'password' => 'demo']);
        $this->Table->insert(['username' => 'Salut', 'password' => 'demo']);
        $count = $this->Table->count();
        $this->assertEquals(2, (int)$count);
        $this->Table->from("user")->delete($this->Table->getPdo()->lastInsertId());
        $count = $this->Table->count();
        $this->assertEquals(1, (int)$count);
    }

}