<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;
use TypeError;

class DownloadHiResImagesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->downloadHiResImagesService = new AmazonService\ProductHiResImage\DownloadHiResImages();
    }

    public function testDownloadHiResImages()
    {
        $this->markTestSkipped('Skip test unless you want to call Amazon.');

        $productEntity = (new AmazonEntity\Product())
            ->setAsin('ASIN001')
            ;

        try {
            $this->downloadHiResImagesService->downloadHiResImages($productEntity);
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $imageEntity1 = new ImageEntity\Image();
        $imageEntity1->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/91cOKoVgnJL._UL1500_.jpg'
        );
        $imageEntity2 = new ImageEntity\Image();
        $imageEntity2->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/81s5s2iDAfL._UL1500_.jpg'
        );
        $productEntity->setHiResImages([
            $imageEntity1,
            $imageEntity2
        ]);

        try {
            $this->downloadHiResImagesService->downloadHiResImages($productEntity);
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $productEntity->setAsin('/malicious/asin');

        try {
            $this->downloadHiResImagesService->downloadHiResImages($productEntity);
        } catch (Exception $exception) {
            $this->assertSame(
                'ASIN contains invalid characters',
                $exception->getMessage()
            );
        }

        $productEntity->setAsin('B0000EZ9SE');

        // Uncomment to actually download from Amazon.
        // $this->downloadHiResImagesService->downloadHiResImages($productEntity);
    }
}
