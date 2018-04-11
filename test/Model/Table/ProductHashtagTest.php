<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductHashtagTest extends AmazonTest\TableCase
{
    /**
     * @var string
     */
    protected $sqlDirectory = __DIR__ . '/../../..' . '/sql/';

    protected function setUp()
    {
        $this->memcachedService = $this->createMock(
            MemcachedService\Memcached::class
        );
        $configArray            = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray            = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter          = new Adapter($configArray);
        $this->productHashtagTable     = new AmazonTable\ProductHashtag(
            $this->memcachedService,
            $this->adapter
        );

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product_hashtag/drop.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product_hashtag/create.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\ProductHashtag::class,
            $this->productHashtagTable
        );
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->productHashtagTable->insertIgnore(1, 2, 3, 4, 5)
        );
        $this->assertSame(
            2,
            $this->productHashtagTable->insertIgnore(1, 3, 8, 9, 10)
        );
        $this->assertSame(
            0,
            $this->productHashtagTable->insertIgnore(1, 2, 8, 9, 10)
        );
    }
}
