<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    protected function setUp()
    {
        $this->randomMp3RruServiceMock = $this->createMock(
            AmazonService\ProductVideo\RandomMp3Rru::class
        );
        $this->commandService = new AmazonService\ProductVideo\Command(
            $this->randomMp3RruServiceMock
        );
    }

    public function testGetCommand()
    {
        $productEntity = new AmazonEntity\Product();

        $productEntity->setAsin('B0000/EZ9SE');
        try {
            $this->commandService->getCommand($productEntity);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Invalid ASIN (this should never happen)',
                $exception->getMessage()
            );
        }

        $productEntity->setAsin('B0000EZ9SE');

        $imageEntity1 = new ImageEntity\Image();
        $imageEntity1->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/41YwIZ9tCqL.jpg'
        );
        $imageEntity2 = new ImageEntity\Image();
        $imageEntity2->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/8*1s5s2iDAfL._UL1500_.jpg'
        );

        $productEntity->setPrimaryImage($imageEntity1);
        $productEntity->setVariantImages([$imageEntity2]);

        try {
            $this->commandService->getCommand($productEntity);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Invalid file name (this should never happen)',
                $exception->getMessage()
            );
        }

        $imageEntity2->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/415ZM5agQYL.jpg'
        );

        $imageEntity3 = new ImageEntity\Image();
        $imageEntity3->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/41q0F0KJdkL.jpg'
        );
        $productEntity->setVariantImages([$imageEntity2, $imageEntity3]);

        $command = $this->commandService->getCommand($productEntity);

        $this->assertInternalType(
            'string',
            $command
        );

        /*
        echo "\n";
        echo $command;
        echo "\n";
         */
    }
}
