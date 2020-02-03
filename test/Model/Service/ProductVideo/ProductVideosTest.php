<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class ProductVideosTest extends TestCase
{
    protected function setUp()
    {
        $this->productVideoFactoryMock = $this->createMock(
            AmazonFactory\ProductVideo::class
        );
        $this->productVideoIdTableMock = $this->createMock(
            AmazonTable\ProductVideo\ProductVideoId::class
        );
        $this->productVideosService = new AmazonService\ProductVideo\ProductVideos(
            $this->productVideoFactoryMock,
            $this->productVideoIdTableMock
        );
    }

    public function testGetProductVideos()
    {
        $this->productVideoIdTableMock
            ->method('selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount')
            ->willReturn($this->yieldArrays());
        $generator = $this->productVideosService->getProductVideos(1);

        $this->assertCount(
            3,
            iterator_to_array($generator)
        );
    }

    protected function yieldArrays()
    {
        yield [];
        yield [];
        yield [];
    }
}
