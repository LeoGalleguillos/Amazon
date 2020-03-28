<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Newest;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class BrowseNodeTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );

        $this->browseNodeService = new AmazonService\Product\Products\Newest\BrowseNode(
            $this->productFactoryMock,
            $this->browseNodeProductTableMock
        );
    }

    public function test_getNewestProducts_emptyResult_zeroProducts()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(12345);

        $this->assertEmpty(
            iterator_to_array(
                $this->browseNodeService->getNewestProducts(
                    $browseNodeEntity,
                    1
                )
            )
        );
    }

    public function test_getNewestProducts_multipleResults_multipleProducts()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(111);

        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator = new TestHydrator\Result();
        $resultHydrator->hydrate(
            $resultMock,
            [
                [
                    'product_id' => '12345',
                ],
                [
                    'product_id' => '54321',
                ],
            ]
        );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(1))
            ->method('selectProductIdWhereBrowseNodeIdLimit')
            ->with(111, 0, 100)
            ->willReturn($resultMock);

        $productEntity1 = new AmazonEntity\Product();
        $productEntity2 = new AmazonEntity\Product();

        $this->productFactoryMock
            ->expects($this->exactly(2))
            ->method('buildFromProductId')
            ->withConsecutive(
                [12345],
                [54321]
            )
            ->will(
                $this->onConsecutiveCalls(
                    $productEntity1,
                    $productEntity2
                )
            );

        $this->assertSame(
            [
                $productEntity1,
                $productEntity2
            ],
            iterator_to_array($this->browseNodeService->getNewestProducts($browseNodeEntity, 1))
        );
    }
}
