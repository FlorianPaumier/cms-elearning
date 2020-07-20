<?php
namespace Tests;

use App\Core\Database\Repository\AbstractRepository;
use App\Core\Database\EntityManager;
use App\Entity\User;
use App\Repository\UserRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase{

    /**
     * @var EntityManager
     */
    private $table;

    /** @var AbstractRepository */
    private $repository;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);

        $pdo->exec('CREATE Table user (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(255),
            password VARCHAR(255),
            roles VARCHAR(255),
            email VARCHAR(255)
        )');

        $this->table = new EntityManager($pdo);
    }
//
//    public function testFind()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->table->setEntity(User::class);
//        $test = $this->table->find(1);
//        $this->assertInstanceOf(User::class, $test);
//        $this->assertEquals('a1', $test->getUsername());
//    }
//
//    public function testFindList()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->assertEquals(['1' => 'a1', '2' => 'a2'], $this->table->findList());
//    }
//
//    public function testFindAll()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->table->setEntity(User::class);
//        $categories = $this->table->findAll();
//        $this->assertCount(2, $categories);
//        $this->assertEquals('a1', $categories[0]->getUsername());
//        $this->assertEquals('a2', $categories[1]->getUsername());
//    }
//
//    public function testFindBy()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->setEntity(User::class);
//        $category = $this->table->findBy(['username' => 'a1']);
//        $this->assertEquals(2, count($category));
//    }
//
//    public function testExists()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->assertTrue($this->table->exists(["username" => "a1"]));
//        $this->table->from("user");
//        $this->assertTrue($this->table->exists(["id" => 2]));
//        $this->table->from("user");
//        $this->assertFalse($this->table->exists(["id" => 100000]));
//    }
//
//    public function testCount()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->assertEquals(3, $this->table->count());
//    }
//
//    public function testCountWithQuery()
//    {
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a2")');
//        $this->table->getPdo()->exec('INSERT INTO user (username) VALUES ("a1")');
//        $this->table->select("username")->where("username = :username")->setParam("username", "a2");
//        $this->assertEquals(1, $this->table->count());
//    }

    public function testInsert()
    {
        $user = (new User())->setEmail("e@e.fr")->setUsername("user")->setPassword("demo");
        $this->table->persist($user)->flush();

        $this->assertEquals(1, $user->getId());
    }

    public function testUpdate()
    {
        $user = (new User())->setUsername("Salut")->setPassword("demo");

        $this->table->persist($user)->flush();

        $user->setEmail("email");
        $this->table->persist($user)->flush();

        $result = $this->table->from("user")->select("username")
            ->where("id = :id")
            ->setParameter("id", $user->getId())
            ->fetch();

        $this->assertEquals('Salut', $result["username"]);
    }

    public function testDelete()
    {
        $user = (new User())->setEmail("e@e.fr")->setUsername("user")->setPassword("demo");
        $user2 = (new User())->setEmail("e@e.fr")->setUsername("user2")->setPassword("demo");
        $this->table->persist($user);
        $this->table->persist($user2);
        $this->table->flush();

        $this->table->from("user")->delete($user);
        $count = $this->table->count();
        $this->assertEquals(1, (int)$count);
    }
}