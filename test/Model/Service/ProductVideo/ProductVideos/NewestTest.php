<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\ProductVideos;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class NewestTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productVideoMock = $this->createMock(
            AmazonTable\ProductVideo::class
        );
        $this->newestService = new AmazonService\ProductVideo\ProductVideos\Newest(
            $this->productFactoryMock,
            $this->productVideoMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductVideo\ProductVideos\Newest::class,
            $this->newestService
        );
    }
}
