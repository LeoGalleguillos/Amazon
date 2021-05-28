<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Exception\InvalidQueryException;
use PHPUnit\Framework\TestCase;

class BrandTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->brandTable = new AmazonTable\Brand(
            $this->getAdapter()
        );

        $this->dropAndCreateTable('brand');
    }

    public function test_insert_resultOrException()
    {
        $result = $this->brandTable->insert('Name', 'slug');
        $this->assertEquals(
            1,
            $result->getGeneratedValue()
        );

        $result = $this->brandTable->insert('Name with same slug', 'slug');
        $this->assertEquals(
            2,
            $result->getGeneratedValue()
        );

        $result = $this->brandTable->insert('Name 3', 'slug-3');
        $this->assertEquals(
            3,
            $result->getGeneratedValue()
        );

        try {
            $result = $this->brandTable->insert('Name', 'slug');
            $this->fail();
        } catch (InvalidQueryException $pdoException) {
            $this->assertSame(
                "Statement could not be executed (23000 - 1062 - Duplicate entry 'Name' for key 'brand.name')",
                $pdoException->getMessage()
            );
        }
    }

    public function test_selectWhereName_result()
    {
        $result = $this->brandTable->selectWhereName('Name');
        $this->assertEmpty($result);

        $this->brandTable->insert('Name', 'slug');
        $result = $this->brandTable->selectWhereName('Name');
        $array = $result->current();

        $this->assertSame(
            [
                'brand_id' => '1',
                'name'     => 'Name',
                'slug'     => 'slug',
            ],
            $array
        );
    }

    public function test_selectWhereSlug_result()
    {
        $result = $this->brandTable->selectWhereSlug('slug');
        $this->assertEmpty($result);

        $this->brandTable->insert('Name', 'slug');
        $result = $this->brandTable->selectWhereSlug('slug');
        $array = $result->current();

        $this->assertSame(
            [
                'brand_id' => '1',
                'name'     => 'Name',
                'slug'     => 'slug',
            ],
            $array
        );
    }
}
