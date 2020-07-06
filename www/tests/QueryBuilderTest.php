<?php
namespace Test;

use App\Core\Database\EntityManager;
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
        $pdo->query('CREATE Table products (
    id INTEGER CONSTRAINT products_pk primary key autoincrement,
    name TEXT,
    address TEXT,
    city TEXT)');
        for ($i = 1; $i <= 10; $i++) {
            $pdo->exec("INSERT INTO products (name, address, city) VALUES ('Product $i', 'Addresse $i', 'Ville $i');");
        }
        return $pdo;
    }

    public function getBuilder(PDO $pdo): EntityManager
    {
        return (new EntityManager($pdo));
    }

    public function testSimpleQuery()
    {
        $q = $this->queryBuilder->from("users", "u")->toSQL();
        $this->assertEquals('SELECT * FROM "users" AS u', $q);
    }

    public function testOrderBy()
    {
        $q = $this->queryBuilder->from("users", "u")->orderBy("id", "DESC")->toSQL();
        $this->assertEquals('SELECT * FROM "users" AS u ORDER BY u.id DESC', $q);
    }

    public function testMultipleOrderBy()
    {
        $this->expectExceptionCode(500);
        $q = $this->queryBuilder
            ->from("users")
            ->orderBy("id", "ezaearz")
            ->orderBy("name", "desc")
            ->toSQL();
    }

    public function testLimit()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->setMaxResult(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" ORDER BY id DESC LIMIT 10', $q);
    }

    public function testOffset()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->setMaxResult(10)
            ->setFirstResult(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" ORDER BY id DESC LIMIT 10 OFFSET 3', $q);
    }

    public function testPageOffset20()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->setMaxResult(10)
            ->page(3)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" ORDER BY id DESC LIMIT 10 OFFSET 20', $q);
    }

    public function testPageOffset0()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->setMaxResult(10)
            ->page(1)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" ORDER BY id DESC LIMIT 10 OFFSET 0', $q);
    }

    public function testCondition()
    {
        $q = $this->queryBuilder
            ->from("users")
            ->where("id > :id")
            ->setParameter("id", 3)
            ->setMaxResult(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" WHERE id > :id ORDER BY id DESC LIMIT 10', $q);
    }

    public function testMultiCondition()
    {

        $q = $this->queryBuilder
            ->from("users")
            ->where("id > :id")
            ->andWhere("name like :name")
            ->setParameter("id", 3)
            ->setParameter("name", "%Produ%")
            ->setMaxResult(10)
            ->orderBy("id", "DESC")
            ->toSQL();
        $this->assertEquals('SELECT * FROM "users" WHERE id > :id AND name like :name ORDER BY id DESC LIMIT 10', $q);
    }

    public function testSelect()
    {
        $q = $this->queryBuilder
            ->select("id", "name", "product")
            ->from("users");
        $this->assertEquals('SELECT id, name, product FROM "users"', $q->toSQL());
    }

    public function testSelectWithAlias()
    {
        $q = $this->queryBuilder
            ->select("id", "name", "product")
            ->from("users", "u");
        $this->assertEquals('SELECT u.id, u.name, u.product FROM "users" AS u', $q->toSQL());
    }

    public function testSelectMultiple()
    {
        $q = $this->queryBuilder
            ->select("id", "name")
            ->from("users")
            ->select('product');
        $this->assertEquals('SELECT id, name, product FROM "users"', $q->toSQL());
    }

    public function testSelectAsArray()
    {
        $q = $this->queryBuilder
            ->select(["id", "name", "product"])
            ->from("users");
        $this->assertEquals('SELECT id, name, product FROM "users"', $q->toSQL());
    }

    public function testFetch()
    {
        $city = $this->queryBuilder
            ->from("products")
            ->where("name = :name")
            ->setParameter("name", "Product 1")
            ->fetch();

        $this->assertEquals("Product 1", $city["name"]);
    }

    public function testFetchWithInvalidRow()
    {
        $city = $this->queryBuilder
            ->from("products")
            ->where("name = :name")
            ->setParameter("name", "azezaeeazazzaez")
            ->fetch();

        $this->assertNull($city);
    }

    public function testCount()
    {
        $query = $this->queryBuilder
            ->from("products")
            ->where("name IN (:name1, :name2)")
            ->setParameter("name1", "Product 1")
            ->setParameter("name2", "Product 2");

        $this->assertEquals('SELECT * FROM "products" WHERE name IN (:name1, :name2)', $query->toSQL());

//        $this->assertEquals(2, $query->count());
    }

    /**
     * L'appel a count ne doit pas modifier les champs de la première requête
     */
    public function testBugCount()
    {
        $q = $this->queryBuilder->from("products");
        $this->assertEquals('SELECT * FROM "products"', $q->toSQL());
//        $this->assertEquals(10, $q->count());
    }

}
