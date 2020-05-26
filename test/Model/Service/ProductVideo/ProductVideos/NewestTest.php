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
    protected function setUp(): void
    {
        $this->productVideoFactoryMock = $this->createMock(
            AmazonFactory\ProductVideo::class
        );
        $this->productVideoTableMock = $this->createMock(
            AmazonTable\ProductVideo::class
        );
        $this->newestService = new AmazonService\ProductVideo\ProductVideos\Newest(
            $this->productVideoFactoryMock,
            $this->productVideoTableMock
        );
    }

    public function testGetNewest()
    {
        $this->productVideoTableMock->method('selectOrderByCreatedDesc')->willReturn(
            $this->yieldArrays()
        );

        $generator = $this->newestService->getNewest();
        $array = iterator_to_array($generator);

        $productVideoEntity = $array[0];
        $this->assertInstanceOf(
            AmazonEntity\ProductVideo::class,
            $productVideoEntity
        );

        $productVideoEntity = $array[1];
        $this->assertInstanceOf(
            AmazonEntity\ProductVideo::class,
            $productVideoEntity
        );
    }

    protected function yieldArrays()
    {
        yield [
            'asin' => 'ABCDEFG',
        ];
        yield [
            'asin' => 'HIJKLMNOP',
        ];
    }
}
