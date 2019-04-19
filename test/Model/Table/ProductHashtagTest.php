<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ProductHashtagTest extends TableTestCase
{
    protected function setUp()
    {
        $this->memcachedService = $this->createMock(
            MemcachedService\Memcached::class
        );
        $this->productHashtagTable     = new AmazonTable\ProductHashtag(
            $this->memcachedService,
            $this->getAdapter()
        );

        $this->dropTable('product_hashtag');
        $this->createTable('product_hashtag');
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
