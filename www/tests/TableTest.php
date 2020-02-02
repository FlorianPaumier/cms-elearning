<?php
namespace Tests\Framework\Database;

use App\Core\Database\Table;
use PDO;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase{

    /**
     * @var Table
     */
    private $table;

    public function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
        $pdo->exec('CREATE TABLE test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255),
            firstname VARCHAR(255)
        )');

        $this->from = new Table($pdo);
        $this->from->from("test");
        $reflection = new \ReflectionClass($this->from);
        $property = $reflection->getProperty('from');
        $property->setAccessible(true);
        $property->setValue($this->from, 'test');
    }


    public function testFind()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $test = $this->from->find(1);
        $this->assertInstanceOf(\stdClass::class, $test);
        $this->assertEquals('a1', $test->name);
    }

    public function testFindList()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertEquals(['1' => 'a1', '2' => 'a2'], $this->from->findList());
    }

    public function testFindAll()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $categories = $this->from->findAll();
        $this->assertCount(2, $categories);
        $this->assertInstanceOf(\stdClass::class, $categories[0]);
        $this->assertEquals('a1', $categories[0]->name);
        $this->assertEquals('a2', $categories[1]->name);
    }

    public function testFindBy()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $category = $this->from->findBy(['name' => 'a1']);
        $this->assertInstanceOf(\stdClass::class, $category);
        $this->assertEquals(1, (int)$category->id);
    }

    public function testExists()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertTrue($this->from->exists(1));
        $this->assertTrue($this->from->exists(2));
        $this->assertFalse($this->from->exists(3123));
    }

    public function testCount()
    {
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->from->getPdo()->exec('INSERT INTO test (name) VALUES ("a1")');

        $this->assertEquals(3, $this->from->count());
    }

    public function testInsert()
    {
        $this->from->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $post = $this->from->find(1);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->firstname);
    }

    public function testUpdate()
    {

        $this->from->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $this->from->update(1, ['name' => 'Salut', 'firstname' => 'demo']);
        $post = $this->from->find(1);
        $this->assertEquals('Salut', $post->name);
        $this->assertEquals('demo', $post->firstname);
    }

    public function testDelete()
    {
        $this->from->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $this->from->insert(['name' => 'Salut', 'firstname' => 'demo']);
        $count = $this->from->getPdo()->query('SELECT COUNT(id) FROM test')->fetchColumn();
        $this->assertEquals(2, (int)$count);
        $this->from->delete($this->from->getPdo()->lastInsertId());
        $count = $this->from->getPdo()->query('SELECT COUNT(id) FROM test')->fetchColumn();
        $this->assertEquals(1, (int)$count);
    }

}