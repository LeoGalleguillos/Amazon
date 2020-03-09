<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class FirstImageEntityTest extends TestCase
{
    protected function setUp()
    {
        $this->firstImageEntityService = new AmazonService\Product\FirstImageEntity();
    }

    public function test_getFirstImageEntity_noPrimaryOrVariantImages_ThrowException()
    {
        $this->expectException(Exception::class);
        $productEntity = new AmazonEntity\Product();
        $this->firstImageEntityService->getFirstImageEntity($productEntity);
    }

    public function test_getFirstImageEntity_emptyVariantImages_ThrowException()
    {
        $this->expectException(Exception::class);
        $productEntity = new AmazonEntity\Product();
        $productEntity->setVariantImages([]);
        $this->firstImageEntityService->getFirstImageEntity($productEntity);
    }

    public function test_getFirstImageEntity_primaryImageOnly_primaryImage()
    {
        $productEntity = new AmazonEntity\Product();
        $imageEntity   = new ImageEntity\Image();
        $productEntity->setPrimaryImage($imageEntity);

        $this->assertSame(
            $imageEntity,
            $this->firstImageEntityService->getFirstImageEntity($productEntity)
        );
    }

    public function test_getFirstImageEntity_variantImagesOnly_firstVariantImage()
    {
        $productEntity = new AmazonEntity\Product();
        $imageEntity1  = new ImageEntity\Image();
        $imageEntity2  = new ImageEntity\Image();
        $productEntity->setVariantImages([
            $imageEntity1,
            $imageEntity2,
        ]);

        $this->assertSame(
            $imageEntity1,
            $this->firstImageEntityService->getFirstImageEntity($productEntity)
        );
    }

    public function test_getFirstImageEntity_primaryAndvariantImages_primaryImage()
    {
        $productEntity = new AmazonEntity\Product();
        $imageEntity1  = new ImageEntity\Image();
        $imageEntity2  = new ImageEntity\Image();
        $imageEntity3  = new ImageEntity\Image();

        $productEntity->setPrimaryImage($imageEntity1);
        $productEntity->setVariantImages([
            $imageEntity2,
            $imageEntity3,
        ]);

        $this->assertSame(
            $imageEntity1,
            $this->firstImageEntityService->getFirstImageEntity($productEntity)
        );
    }
}
