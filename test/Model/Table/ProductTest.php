<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/product/';

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

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(AmazonTable\Product::class, $this->productTable);
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $productEntity       = new AmazonEntity\Product();
        $productEntity->asin  = 'ASIN';
        $productEntity->title = 'Test Product';
        $productEntity->listPrice = 0.00;
        $productEntity->productGroup = 'Product Group';
        $productEntity->binding = 'Binding';
        $productEntity->brand = 'Brand';

        $this->assertSame(
            1,
            $this->productTable->insertOnDuplicateKeyUpdate($productEntity)
        );
        $this->assertSame(
            0,
            $this->productTable->insertOnDuplicateKeyUpdate($productEntity)
        );
    }
}
