<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductsTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->productsTable     = new AmazonTable\Products(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks0();
        $this->dropTable('product');
        $this->createTable('product');
        $this->setForeignKeyChecks1();
    }

    public function testSelectAsinWhereProductGroupAndModified()
    {
        $generator = $this->productsTable->selectAsinWhereProductGroupAndModified(
            'Toy',
            '2018-01-01 12:12:12'
        );
        $this->assertInstanceOf(
            Generator::class,
            $generator
        );
    }
}
