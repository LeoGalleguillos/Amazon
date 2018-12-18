<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\ProductVideos;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SimilarTest extends TestCase
{
    protected function setUp()
    {
        $this->productVideoFactoryMock = $this->createMock(
            AmazonFactory\ProductVideo::class
        );
        $this->productVideoTableMock = $this->createMock(
            AmazonTable\ProductVideo::class
        );
        $this->similarService = new AmazonService\ProductVideo\ProductVideos\Similar(
            $this->productVideoFactoryMock,
            $this->productVideoTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\ProductVideo\ProductVideos\Similar::class,
            $this->similarService
        );
    }
}
