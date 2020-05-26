<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ProductGroupExcludedTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productGroupExcludedService = new AmazonService\ProductVideo\ProductGroupExcluded();
    }

    public function testIsProductGroupExcluded()
    {
        $productEntity = new AmazonEntity\Product();
        $this->assertFalse(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );

        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productEntity->setProductGroup($productGroupEntity);
        $this->assertFalse(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );

        $productGroupEntity->setName('Apparel');
        $this->assertFalse(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );

        $productGroupEntity->setName('Courseware');
        $this->assertTrue(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );

        $productGroupEntity->setName('TV Series Season Video on Demand');
        $this->assertTrue(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );

        $productGroupEntity->setName('Health and Beauty');
        $this->assertFalse(
            $this->productGroupExcludedService->isProductGroupExcluded($productEntity)
        );
    }
}
