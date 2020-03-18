<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    protected function setUp()
    {
        $this->productEntity = new AmazonEntity\Product();
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

        $browseNodeProducts = [
            new AmazonEntity\BrowseNodeProduct(),
            new AmazonEntity\BrowseNodeProduct(),
            new AmazonEntity\BrowseNodeProduct(),
        ];
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setBrowseNodeProducts($browseNodeProducts)
        );
        $this->assertSame(
            $browseNodeProducts,
            $this->productEntity->getBrowseNodeProducts()
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

        $isbns = [
            '1234567890',
            '2234567890',
            '3234567890',
        ];
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setIsbns($isbns)
        );
        $this->assertSame(
            $isbns,
            $this->productEntity->getIsbns()
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

        $isEligibleForTradeIn = true;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setIsEligibleForTradeIn($isEligibleForTradeIn)
        );
        $this->assertSame(
            $isEligibleForTradeIn,
            $this->productEntity->getIsEligibleForTradeIn()
        );

        $isValid = true;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setIsValid($isValid)
        );
        $this->assertSame(
            $isValid,
            $this->productEntity->getIsValid()
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

        $manufacturer = 'Jiskha LLC';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setManufacturer($manufacturer)
        );
        $this->assertSame(
            $manufacturer,
            $this->productEntity->getManufacturer()
        );

        $model = 'Model';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setModel($model)
        );
        $this->assertSame(
            $model,
            $this->productEntity->getModel()
        );

        $partNumber = 'Part Number';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setPartNumber($partNumber)
        );
        $this->assertSame(
            $partNumber,
            $this->productEntity->getPartNumber()
        );

        $released = new DateTime('1983-10-22 19:45:01');
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setReleased($released)
        );
        $this->assertSame(
            $released,
            $this->productEntity->getReleased()
        );

        $size = 'Medium';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setSize($size)
        );
        $this->assertSame(
            $size,
            $this->productEntity->getSize()
        );

        $tradeInPrice = 19.95;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setTradeInPrice($tradeInPrice)
        );
        $this->assertSame(
            $tradeInPrice,
            $this->productEntity->getTradeInPrice()
        );

        $unitCount = 7;
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setUnitCount($unitCount)
        );
        $this->assertSame(
            $unitCount,
            $this->productEntity->getUnitCount()
        );

        $upcs = [
            '123456789012',
            '923456789013',
        ];
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setUpcs($upcs)
        );
        $this->assertSame(
            $upcs,
            $this->productEntity->getUpcs()
        );

        $warranty = 'This is the warranty.';
        $this->assertSame(
            $this->productEntity,
            $this->productEntity->setWarranty($warranty)
        );
        $this->assertSame(
            $warranty,
            $this->productEntity->getWarranty()
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
