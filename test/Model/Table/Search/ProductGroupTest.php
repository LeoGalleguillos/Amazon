<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Search;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../../..' . '/sql/leogalle_test/search_product_group_toy/';

    protected function setUp()
    {
        $this->memcachedService = $this->createMock(MemcachedService\Memcached::class);
        $configArray            = require(__DIR__ . '/../../../../config/autoload/local.php');
        $configArray            = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter          = new Adapter($configArray);
        $this->searchProductGroupTable     = new AmazonTable\Search\ProductGroup(
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
        $this->assertInstanceOf(
            AmazonTable\Search\ProductGroup::class,
            $this->searchProductGroupTable
        );
    }

    public function testSelectProductIdWhereMatchTitleAgainst()
    {
        $productIds = $this->searchProductGroupTable
             ->selectProductIdWhereMatchTitleAgainst(
            'search_product_group_toy',
            'example search query',
            1
        );
        $this->assertSame(
            [],
            $productIds
        );
    }

    public function testSelectProductIdWhereMatchTitleAgainstAndProductIdDoesNotEqual()
    {
        $productIds = $this->searchProductGroupTable
             ->selectProductIdWhereMatchTitleAgainstAndProductIdDoesNotEqual(
            'search_product_group_toy',
            'example search query',
            123,
            0,
            100
        );
        $this->assertSame(
            [],
            $productIds
        );
    }
}
