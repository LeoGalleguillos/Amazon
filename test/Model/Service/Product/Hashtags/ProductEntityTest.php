<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Hashtags;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class ProductEntityTest extends TestCase
{
    protected function setUp()
    {
        $this->productEntityService = new AmazonService\Product\Hashtags\ProductEntity();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Hashtags\ProductEntity::class,
            $this->productEntityService
        );
    }

    public function testGetHashtags()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setTitle('Example Product');

        $this->assertSame(
            [],
            $this->productEntityService->getHashtags($productEntity)
        );

        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setName('Example Product Group');
        $productEntity->setProductGroupEntity($productGroupEntity);

        $this->assertSame(
            ['example', 'product'],
            $this->productEntityService->getHashtags($productEntity)
        );
    }
}
