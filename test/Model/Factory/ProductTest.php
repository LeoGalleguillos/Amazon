<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
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
            'product_id'    => '12345',
            'asin'          => 'ASIN',
            'title'         => 'Title',
            'list_price'    => '1.23',
            'product_group' => 'Product Group',
            'Binding'       => 'Binding',
            'Brand'         => 'Brand',
        ];
        $productEntity = $this->productFactory->buildFromArray($array);

        $this->assertSame(
            'ASIN',
            $productEntity->getAsin()
        );
    }
}
