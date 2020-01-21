<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\ProductVideos;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\String\Model\Service as StringService;
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
        $this->keepFirstWordsMock = $this->createMock(
            StringService\KeepFirstWords::class
        );
        $this->similarService = new AmazonService\ProductVideo\ProductVideos\Similar(
            $this->productVideoFactoryMock,
            $this->productVideoTableMock,
            $this->keepFirstWordsMock
        );
    }

    public function testGetSimilar()
    {
        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity
            ->setAsin('ASIN')
            ->setTitle('Title of the Product Video');

        $this->productVideoTableMock->method('selectAsinWhereMatchAgainst')->willReturn(
            $this->yieldAsins()
        );

        $generator = $this->similarService->getSimilar(
            $productVideoEntity
        );
        $array = iterator_to_array($generator);
        $this->assertCount(
            2,
            $array
        );
    }

    protected function yieldAsins()
    {
        yield 'ASIN1';
        yield 'ASIN2';
    }
}
