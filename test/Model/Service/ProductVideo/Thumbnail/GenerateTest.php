<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\Thumbnail;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    protected function setUp()
    {
        $this->generateService = new AmazonService\ProductVideo\Thumbnail\Generate();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductVideo\Thumbnail\Generate::class,
            $this->generateService
        );
    }

    public function testGenerate()
    {
        $imageEntity = new ImageEntity\Image();
        $imageEntity->setUrl('https://images-na.ssl-images-amazon.com/images/I/71NZRr%2BnbCL._UL1500_.jpg');
        $productEntity      = new AmazonEntity\Product();
        $productEntity->setAsin('B07J1Q4GZC')
                      ->setHiResImages([$imageEntity]);
        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity->setProduct($productEntity);

        $this->assertInternalType(
            'bool',
            $this->generateService->generate($productVideoEntity)
        );
    }
}
