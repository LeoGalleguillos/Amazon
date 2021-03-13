<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use Laminas\Db\Adapter\Exception\InvalidQueryException;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();
    }

    public function test_insertAsin_uniqueAsin_success()
    {
        $result = $this->productTable->insertAsin('ASIN001');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
        $this->assertSame(
            '1',
            $result->getGeneratedValue()
        );
    }

    public function test_insertAsin_duplicateAsin_invalidQueryException()
    {
        $this->expectException(InvalidQueryException::class);
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN002');
    }

    public function test_select_emptyResult()
    {
        $result = $this->productTable->select(0, 100);
        $this->assertEmpty($result);
    }

    public function test_select_desiredResult()
    {
        $this->productTable->insertAsin('ASIN001');
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN003');
        $this->productTable->insertAsin('ASIN004');
        $result = $this->productTable->select(1, 2);
        $array = $result->current();
        $this->assertSame(
            'ASIN002',
            $array['asin']
        );
        $result->next();
        $array = $result->current();
        $this->assertSame(
            'ASIN003',
            $array['asin']
        );
        $result->next();
        $this->assertFalse($result->current());
    }
}
