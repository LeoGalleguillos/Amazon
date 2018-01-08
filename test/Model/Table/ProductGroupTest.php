<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use Exception;
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
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/product_group/';

    protected function setUp()
    {
        $this->memcachedService = $this->createMock(MemcachedService\Memcached::class);
        $configArray            = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray            = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter          = new Adapter($configArray);
        $this->productGroupTable     = new AmazonTable\ProductGroup(
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
        $this->assertInstanceOf(AmazonTable\ProductGroup::class, $this->productGroupTable);
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->productGroupTable->insertIgnore('name', 'slug')
        );
        $this->assertSame(
            2,
            $this->productGroupTable->insertIgnore('another name', 'another-slug')
        );
        $this->assertSame(
            0,
            $this->productGroupTable->insertIgnore('name', 'slug')
        );
    }

    public function testSelectWhereProductGroupId()
    {
        $this->productGroupTable->insertIgnore('name', 'slug');
        $arrayObject = new ArrayObject([
            'product_group_id' => '1',
            'name' => 'name',
            'slug' => 'slug',
        ]);
        $this->assertEquals(
            $arrayObject,
            $this->productGroupTable->selectWhereProductGroupId(1)
        );

        try {
            $this->productGroupTable->selectWhereProductGroupId(2);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Product group ID not found.',
                $exception->getMessage()
            );
        }
    }
}
