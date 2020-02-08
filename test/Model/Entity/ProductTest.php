<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    protected function setUp()
    {
        $this->productEntity = new AmazonEntity\Product();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonEntity\Product::class,
            $this->productEntity
        );
    }

    public function testGettersAndSetters()
    {
        $asin = 'ASIN';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setAsin($asin)
        );
        $this->assertSame(
            $asin,
            $this->productEntity->getAsin()
        );

        $color = 'red, white, & blue';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setColor($color)
        );
        $this->assertSame(
            $color,
            $this->productEntity->getColor()
        );

        $isAdultProduct = false;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setIsAdultProduct($isAdultProduct)
        );
        $this->assertSame(
            $isAdultProduct,
            $this->productEntity->getIsAdultProduct()
        );

        $imageEntity = new ImageEntity\Image();
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setPrimaryImage($imageEntity)
        );
        $this->assertSame(
            $imageEntity,
            $this->productEntity->getPrimaryImage()
        );
    }
}
