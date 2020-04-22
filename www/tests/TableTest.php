<?php
namespace Tests\Framework\Database;

use App\Core\Database\Table;
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

        $pdo->exec('CREATE Table test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255),
            firstname VARCHAR(255)
        )');

        $this->Table = new Table($pdo);
        $this->Table->from("test");
        $reflection = new \ReflectionClass($this->Table);
        $property = $reflection->getProperty('from');
        $property->setAccessible(true);
        $property->setValue($this->Table, 'test');
    }


    public function testFind()
    {
        $this->Table->setEntity(\stdClass::class);
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $test = $this->Table->find(1);
        $this->assertInstanceOf(\stdClass::class, $test);
        $this->assertEquals('a1', $test->name);
    }

    public function testFindList()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertEquals(['1' => 'a1', '2' => 'a2'], $this->Table->findList());
    }

    public function testFindAll()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $categories = $this->Table->findAll();
        $this->assertCount(2, $categories);
        $this->assertEquals('a1', $categories[0]["name"]);
        $this->assertEquals('a2', $categories[1]["name"]);
    }

    public function testFindBy()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->setEntity(\stdClass::class);
        $category = $this->Table->findBy(['name' => 'a1']);
        $this->assertInstanceOf(\stdClass::class, $category);
        $this->assertEquals(1, (int)$category->id);
    }

    public function testExists()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertTrue($this->Table->exists(["name" => "a1"]));
        $this->assertTrue($this->Table->exists(["id" => 2]));
        $this->assertFalse($this->Table->exists(["id" => 100000]));
    }

    public function testCount()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->assertEquals(3, $this->Table->count());
    }

    public function testCountWithQuery()
    {
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->Table->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->Table->select("name")->where("name = :name")->setParam("name", "a2");
        $this->assertEquals(1, $this->Table->count());
    }

    public function testInsert()
    {
        $this->Table->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $this->Table->setEntity(\StdClass::class);

        $post = $this->Table->find(1);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->firstname);
    }

    public function testUpdate()
    {

        $this->Table->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $this->Table->setEntity(\StdClass::class);
        $insert = $this->Table->find(1);
        $this->assertEquals('Salut', $insert->name);
        $this->assertEquals('demo', $insert->firstname);

        $this->Table->update(1, ['name' => 'Salut', 'firstname' => 'demo']);
        $update = $this->Table->find(1);
        $this->Table->setEntity(\StdClass::class);
        $this->assertEquals('Salut', $update->name);
        $this->assertEquals('demo', $update->firstname);
    }

    public function testDelete()
    {
        $this->Table->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $this->Table->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $count = $this->Table->count();
        $this->assertEquals(2, (int)$count);
        $this->Table->delete($this->Table->getPdo()->lastInsertId());
        $count = $this->Table->count();
        $this->assertEquals(1, (int)$count);
    }

}