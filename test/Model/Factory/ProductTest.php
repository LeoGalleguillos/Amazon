<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

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
        $this->productEditorialReviewFactoryMock = $this->createMock(AmazonFactory\Product\EditorialReview::class);
        $this->productGroupFactoryMock = $this->createMock(AmazonFactory\ProductGroup::class);
        $this->imageFactoryMock = $this->createMock(ImageFactory\Image::class);
        $this->productTableMock = $this->createMock(AmazonTable\Product::class);
        $this->productEditorialReviewTableMock = $this->createMock(AmazonTable\Product\EditorialReview::class);
        $this->productFeatureTableMock = $this->createMock(AmazonTable\Product\Feature::class);
        $this->productImageTableMock = $this->createMock(AmazonTable\Product\Image::class);

        $this->productFactory = new AmazonFactory\Product(
            $this->bindingFactoryMock,
            $this->brandFactoryMock,
            $this->productEditorialReviewFactoryMock,
            $this->productGroupFactoryMock,
            $this->imageFactoryMock,
            $this->productTableMock,
            $this->productEditorialReviewTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(AmazonFactory\Product::class, $this->productFactory);
    }
}
