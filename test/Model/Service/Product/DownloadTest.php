<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class DownloadTest extends TestCase
{
    protected function setUp()
    {
        $this->bindingServiceMock = $this->createMock(
            AmazonService\Binding::class
        );
        $this->brandServiceMock = $this->createMock(
            AmazonService\Brand::class
        );
        $this->productGroupServiceMock = $this->createMock(
            AmazonService\ProductGroup::class
        );
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );
        $this->productEditorialReviewTableMock = $this->createMock(
            AmazonTable\Product\EditorialReview::class
        );
        $this->productFeatureTableMock = $this->createMock(
            AmazonTable\ProductFeature::class
        );
        $this->productImageTableMock = $this->createMock(
            AmazonTable\ProductImage::class
        );

        $this->downloadService = new AmazonService\Product\Download(
            $this->bindingServiceMock,
            $this->brandServiceMock,
            $this->productGroupServiceMock,
            $this->productTableMock,
            $this->productEditorialReviewTableMock,
            $this->productFeatureTableMock,
            $this->productImageTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\Download::class,
            $this->downloadService
        );
    }
}
