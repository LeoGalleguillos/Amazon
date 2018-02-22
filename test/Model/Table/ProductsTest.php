<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductsTest extends AmazonTest\TableCase
{
    /**
     * @var string
     */
    protected $sqlDirectory = __DIR__ . '/../../..' . '/sql/';

    protected function setUp()
    {
        $this->memcachedService = $this->createMock(MemcachedService\Memcached::class);
        $configArray            = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray            = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter          = new Adapter($configArray);
        $this->productTable     = new AmazonTable\Product(
            $this->memcachedService,
            $this->adapter
        );
        $this->productsTable     = new AmazonTable\Products(
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
            AmazonTable\Products::class,
            $this->productsTable
        );
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
