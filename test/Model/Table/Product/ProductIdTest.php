<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductIdTest extends AmazonTest\TableCase
{
    protected function setUp()
    {
        parent::setup();

        $this->productIdTable = new AmazonTable\Product\ProductId(
            $this->adapter
        );

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product/drop.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product/create.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\Product\ProductId::class,
            $this->productIdTable
        );
    }
}
