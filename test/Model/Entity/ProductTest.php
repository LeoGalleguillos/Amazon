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

        $heightUnits = 'Centimeters';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setHeightUnits($heightUnits)
        );
        $this->assertSame(
            $heightUnits,
            $this->productEntity->getHeightUnits()
        );

        $heightValue = 3.14159;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setHeightValue($heightValue)
        );
        $this->assertSame(
            $heightValue,
            $this->productEntity->getHeightValue()
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

        $lengthUnits = 'Inches';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setLengthUnits($lengthUnits)
        );
        $this->assertSame(
            $lengthUnits,
            $this->productEntity->getLengthUnits()
        );

        $lengthValue = 2.718;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setLengthValue($lengthValue)
        );
        $this->assertSame(
            $lengthValue,
            $this->productEntity->getLengthValue()
        );

        $weightUnits = 'Pounds';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setWeightUnits($weightUnits)
        );
        $this->assertSame(
            $weightUnits,
            $this->productEntity->getWeightUnits()
        );

        $weightValue = 50.5;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setWeightValue($weightValue)
        );
        $this->assertSame(
            $weightValue,
            $this->productEntity->getWeightValue()
        );

        $widthUnits = 'Feet';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setWidthUnits($widthUnits)
        );
        $this->assertSame(
            $widthUnits,
            $this->productEntity->getWidthUnits()
        );

        $widthValue = 7.0;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setWidthValue($widthValue)
        );
        $this->assertSame(
            $widthValue,
            $this->productEntity->getWidthValue()
        );
    }
}
