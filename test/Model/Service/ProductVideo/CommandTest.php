<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

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
        $this->commandService = new AmazonService\ProductVideo\Command();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductVideo\Command::class,
            $this->commandService
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
            'https://images-na.ssl-images-amazon.com/images/I/91cOKoVgnJL._UL1500_.jpg'
        );
        $imageEntity2 = new ImageEntity\Image();
        $imageEntity2->setUrl(
            'https://images-na.ssl-images-amazon.com/images/I/8*1s5s2iDAfL._UL1500_.jpg'
        );
        $productEntity->setHiResImages([
            $imageEntity1,
            $imageEntity2
        ]);

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
            'https://images-na.ssl-images-amazon.com/images/I/81s5s2iDAfL._UL1500_.jpg'
        );

        $command = $this->commandService->getCommand($productEntity);

        $this->assertInternalType(
            'string',
            $command
        );

    }
}
