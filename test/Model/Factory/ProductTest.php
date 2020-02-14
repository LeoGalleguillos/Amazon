<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    protected function setUp()
    {
        $this->bindingFactoryMock = $this->createMock(AmazonFactory\Binding::class);
        $this->brandFactoryMock = $this->createMock(AmazonFactory\Brand::class);
        $this->productGroupFactoryMock = $this->createMock(AmazonFactory\ProductGroup::class);
        $this->imageFactoryMock = $this->createMock(ImageFactory\Image::class);
        $this->productTableMock = $this->createMock(AmazonTable\Product::class);
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );
        $this->productFeatureTableMock = $this->createMock(AmazonTable\ProductFeature::class);
        $this->productImageTableMock = $this->createMock(AmazonTable\ProductImage::class);
        $this->productHiResImageTableMock = $this->createMock(AmazonTable\ProductHiResImage::class);

        $this->productFactory = new AmazonFactory\Product(
            $this->bindingFactoryMock,
            $this->brandFactoryMock,
            $this->productGroupFactoryMock,
            $this->imageFactoryMock,
            $this->productTableMock,
            $this->asinTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock,
            $this->productHiResImageTableMock
        );
    }

    public function testBuildFromArray()
    {
        $array = [
            'product_id'       => '12345',
            'asin'             => 'ASIN',
            'title'            => 'Title',
            'list_price'       => '1.23',
            'color'            => 'Red',
            'is_adult_product' => '0',
            'height_units'     => 'inches',
            'height_value'     => '1.0',
            'length_units'     => 'cm',
            'length_value'     => '3.14159',
            'weight_units'     => 'LBS',
            'weight_value'     => '1000',
            'width_units'      => 'feet',
            'width_value'      => '10.0',
            'released'         => '2020-02-08 12:12:45',
            'size'             => 'Medium',
            'unit_count'       => 7,
        ];
        $productEntity = (new AmazonEntity\Product())
            ->setAsin('ASIN')
            ->setColor('Red')
            ->setIsAdultProduct(false)
            ->setHeightUnits('inches')
            ->setHeightValue('1.0')
            ->setLengthUnits('cm')
            ->setLengthValue('3.14159')
            ->setProductId('12345')
            ->setListPrice('1.23')
            ->setReleased(new DateTime('2020-02-08 12:12:45'))
            ->setSize('Medium')
            ->setTitle('Title')
            ->setUnitCount(7)
            ->setWeightUnits('LBS')
            ->setWeightValue('1000')
            ->setWidthUnits('feet')
            ->setWidthValue('10.0')
            ;

        $this->assertEquals(
            $productEntity,
            $this->productFactory->buildFromArray($array)
        );
    }
}
