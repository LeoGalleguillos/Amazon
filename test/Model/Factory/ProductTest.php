<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use DateTime;
use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use PHPUnit\Framework\TestCase;
use Laminas\Db\Adapter\Driver\Pdo\Result;

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
        $this->productEanProductIdTableMock = $this->createMock(
            AmazonTable\ProductEan\ProductId::class
        );
        $this->productFeatureTableMock = $this->createMock(AmazonTable\ProductFeature::class);
        $this->productImageTableMock = $this->createMock(AmazonTable\ProductImage::class);
        $this->productUpcProductIdTableMock = $this->createMock(
            AmazonTable\ProductUpc\ProductId::class
        );

        $this->productFactory = new AmazonFactory\Product(
            $this->bindingFactoryMock,
            $this->brandFactoryMock,
            $this->productGroupFactoryMock,
            $this->imageFactoryMock,
            $this->productTableMock,
            $this->asinTableMock,
            $this->productEanProductIdTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock,
            $this->productUpcProductIdTableMock
        );

        $this->productEanResultMock = $this->createMock(
            Result::class
        );
        $this->productUpcResultMock = $this->createMock(
            Result::class
        );
    }

    public function testBuildFromArray()
    {
        $this->productEanResultMock
            ->method('valid')
            ->will(
                $this->onConsecutiveCalls(
                    true,
                    true,
                    true
                )
            );
        $this->productEanResultMock
            ->method('current')
            ->will(
                $this->onConsecutiveCalls(
                    ['product_id' => '12345', 'ean' => '1234567890123'],
                    ['product_id' => '12345', 'ean' => '1234567890124'],
                    ['product_id' => '12345', 'ean' => '1234567890125']
                )
            );
        $this->productEanProductIdTableMock
            ->method('selectWhereProductId')
            ->willReturn(
                $this->productEanResultMock
            );
        $this->productFeatureTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductFeatureArrays()
            );

        $this->productImageTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductImageArrays()
            );
        $this->productUpcResultMock
            ->method('valid')
            ->will(
                $this->onConsecutiveCalls(
                    true,
                    true
                )
            );
        $this->productUpcResultMock
            ->method('current')
            ->will(
                $this->onConsecutiveCalls(
                    ['product_id' => '12345', 'upc' => '123456789012'],
                    ['product_id' => '12345', 'upc' => '123456789013']
                )
            );
        $this->productUpcProductIdTableMock
            ->method('selectWhereProductId')
            ->willReturn(
                $this->productUpcResultMock
            );

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
            ->setEans([
                '1234567890123',
                '1234567890124',
                '1234567890125',
            ])
            ->setFeatures([
                'This is the first feature.',
                'This is the second feature.',
            ])
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
            ->setUpcs([
                '123456789012',
                '123456789013',
            ])
            ->setVariantImages([
                null,
                null
            ])
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

    public function testBuildFromAsin()
    {
        $this->asinTableMock
            ->method('selectWhereAsin')
            ->willReturn([
                'product_id' => 12345,
                'asin'       => 'ASIN12345',
            ]);

        $this->productFeatureTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductFeatureArrays()
            );

        $this->productImageTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductImageArrays()
            );

        $productEntity = (new AmazonEntity\Product())
            ->setAsin('ASIN12345')
            ->setFeatures([
                'This is the first feature.',
                'This is the second feature.',
            ])
            ->setProductId('12345')
            ->setVariantImages([
                null,
                null
            ]);
            ;

        $this->assertEquals(
            $productEntity,
            $this->productFactory->buildFromAsin('ASIN12345')
        );
    }

    public function testBuildFromProductId()
    {
        $this->productTableMock
            ->method('selectWhereProductId')
            ->willReturn([
                'product_id' => 12345,
                'asin'       => 'ASIN12345',
            ]);

        $this->productFeatureTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductFeatureArrays()
            );

        $this->productImageTableMock
            ->method('selectWhereAsin')
            ->willReturn(
                $this->yieldProductImageArrays()
            );

        $productEntity = (new AmazonEntity\Product())
            ->setAsin('ASIN12345')
            ->setFeatures([
                'This is the first feature.',
                'This is the second feature.',
            ])
            ->setProductId('12345')
            ->setVariantImages([
                null,
                null
            ]);
            ;

        $this->assertEquals(
            $productEntity,
            $this->productFactory->buildFromProductId(12345)
        );
    }

    protected function yieldProductFeatureArrays(): Generator
    {
        yield [
            'product_id' => 1,
            'asin'       => 'ASIN12345',
            'feature'    => 'This is the first feature.',
        ];

        yield [
            'product_id' => 1,
            'asin'       => 'ASIN12345',
            'feature'    => 'This is the second feature.',
        ];
    }

    protected function yieldProductImageArrays(): Generator
    {
        yield [
            'url'      => 'https://www.example.com/images/product/asin12345/1.jpg',
            'category' => 'primary',
        ];

        yield [
            'url'      => 'https://www.example.com/images/product/asin12345/2.jpg',
            'category' => 'variant',
        ];

        yield [
            'url'      => 'https://www.example.com/images/product/asin12345/3.jpg',
            'category' => 'variant',
        ];
    }
}
