<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\ProductVideo\ProductVideos;

use Exception;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class BrowseNodeTest extends TestCase
{
    protected function setUp()
    {
        $this->productVideoFactoryMock = $this->createMock(
            AmazonFactory\ProductVideo::class
        );
        $this->productVideoTableMock = $this->createMock(
            AmazonTable\ProductVideo::class
        );
        $this->browseNodeService = new AmazonService\ProductVideo\ProductVideos\BrowseNode(
            $this->productVideoFactoryMock,
            $this->productVideoTableMock
        );
    }

    public function testGetProductVideos()
    {
        $resultMock = $this->createMock(
            Result::class
        );
        $this->productVideoTableMock
            ->method('selectProductVideoIdWhereBrowseNodeId')
            ->willReturn(
                $resultMock
            );

        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(777);

        $generator = $this->browseNodeService->getProductVideos(
            $browseNodeEntity,
            3
        );
        $array = iterator_to_array($generator);

        $this->assertEmpty(
            $array
        );
    }
}
