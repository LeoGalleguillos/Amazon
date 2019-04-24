<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductImage;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class ProductImagesTest extends TestCase
{
    protected function setUp()
    {
        $this->productImagesService = new AmazonService\ProductImage\ProductImages();
    }

    public function testProductWithNoImages()
    {
        $productEntity = new AmazonEntity\Product();
        $this->assertSame(
            [],
            $this->productImagesService->getProductImages($productEntity)
        );
    }

    public function testProductWithPrimaryImageOnly()
    {
        $productEntity = new AmazonEntity\Product();
        $primaryImage = new ImageEntity\Image();
        $productEntity->setPrimaryImage($primaryImage);
        $this->assertSame(
            [
                $primaryImage,
            ],
            $this->productImagesService->getProductImages($productEntity)
        );
    }

    public function testProductWithVariantImagesOnly()
    {
        $productEntity = new AmazonEntity\Product();

        $variantImages = [
            new ImageEntity\Image(),
            new ImageEntity\Image(),
            new ImageEntity\Image(),
        ];
        $productEntity->setVariantImages($variantImages);

        $this->assertSame(
            $variantImages,
            $this->productImagesService->getProductImages($productEntity)
        );
    }

    public function testProductWithPrimaryAndVariantImages()
    {
        $productEntity = new AmazonEntity\Product();

        $primaryImage = new ImageEntity\Image();
        $productEntity->setPrimaryImage($primaryImage);

        $variantImages = [
            new ImageEntity\Image(),
            new ImageEntity\Image(),
            new ImageEntity\Image(),
        ];
        $productEntity->setVariantImages($variantImages);

        $this->assertSame(
            array_merge(
                [$primaryImage],
                $variantImages
            ),
            $this->productImagesService->getProductImages($productEntity)
        );
    }
}
