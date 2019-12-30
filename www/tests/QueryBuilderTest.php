<?php
namespace Test;

use App\Core\Database\Table;
use PDO;
use PHPUnit\Framework\TestCase;

final class QueryBuilderTest extends TestCase
{
    private $queryBuilder;

    public function setUp(): void
    {
        $pdo = $this->getPDO();
        $this->queryBuilder = $this->getBuilder($pdo);
    }

    public function getPDO(): PDO
    {
        $pdo = new PDO("sqlite::memory:");
        $pdo->query('CREATE TABLE products (
    id INTEGER CONSTRAINT products_pk primary key autoincrement,
    name TEXT,
    address TEXT,
    city TEXT)');
        for ($i = 1; $i <= 10; $i++) {
            $pdo->exec("INSERT INTO products (name, address, city) VALUES ('Product $i', 'Addresse $i', 'Ville $i');");
        }
        return $pdo;
    }

    public function getBuilder(PDO $pdo): Table
    {
        return new Table($pdo);
    }

    public function testSimpleQuery()
    {
        $q = $this->queryBuilder->from("users", "u")->toSQL();
        $this->assertEquals("SELECT * FROM users u", $q);
    }

    public function testOrderBy()
    {
        $q = $this->queryBuilder->from("users", "u")->orderBy("id", "DESC")->toSQL();
        $this->assertEquals("SELECT * FROM users u ORDER BY id DESC", $q);
    }

    public function testMultipleOrderBy()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->orderBy("id", "ezaearz")
            ->orderBy("name", "desc")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id, name DESC", $q);
    }

    public function testLimit()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->limit(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10", $q);
    }

    public function testOffset()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->limit(10)
            ->offset(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 3", $q);
    }

    public function testPageOffset20()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->limit(10)
            ->page(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 20", $q);
    }

    public function testPageOffset0()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->limit(10)
            ->page(1)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users ORDER BY id DESC LIMIT 10 OFFSET 0", $q);
    }

    public function testCondition()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->where("id > :id")
            ->setParam("id", 3)
            ->limit(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users WHERE id > :id ORDER BY id DESC LIMIT 10", $q);
    }

    public function testMultiCondition()
    {

        $q = $this->queryBuilder
            ->from("users")
            ->where("id > :id")
            ->andWhere("name like :name")
            ->setParam("id", 3)
            ->setParam("name", "%Produ%")
            ->limit(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals("SELECT * FROM users WHERE id > :id AND WHERE name like :name ORDER BY id DESC LIMIT 10", $q);
    }

    public function testSelect()
    {
        $q = $this->queryBuilder
            ->select("id", "name", "product")
            ->from("users");
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testSelectMultiple()
    {
        $q = $this->queryBuilder
            ->select("id", "name")
            ->from("users")
            ->select('product');
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testSelectAsArray()
    {
        $q = $this->queryBuilder
            ->select(["id", "name", "product"])
            ->from("users");
        $this->assertEquals("SELECT id, name, product FROM users", $q->toSQL());
    }

    public function testFetch()
    {
        $city = $this->queryBuilder
            ->from("products")
            ->where("name = :name")
            ->setParam("name", "Product 1")
            ->fetchOrFail();
        $this->assertEquals("Ville 1", $city->city);
    }

    public function testFetchWithInvalidRow()
    {
        $city = $this->queryBuilder
            ->from("products")
            ->where("name = :name")
            ->setParam("name", "azezaeeazazzaez")
            ->fetchOrFail( "city");
        $this->assertNull($city);
    }

    public function testCount()
    {
        $query = $this->queryBuilder
            ->from("products")
            ->where("name IN (:name1, :name2)")
            ->setParam("name1", "Product 1")
            ->setParam("name2", "Product 2");
        $this->assertEquals(2, $query->count());
    }

    /**
     * L'appel a count ne doit pas modifier les champs de la première requête
     */
    public function testBugCount()
    {
        $q = $this->queryBuilder->from("products");
        $this->assertEquals(10, $q->count());
        $this->assertEquals("SELECT * FROM products", $q->toSQL());
    }

}
