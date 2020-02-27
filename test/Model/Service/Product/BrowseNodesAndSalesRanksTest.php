<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class BrowseNodesAndSalesRanksTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeFactoryMock = $this->createMock(
            AmazonFactory\BrowseNode::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );

        $this->browseNodesAndSalesRanksService = new AmazonService\Product\BrowseNodesAndSalesRanks(
            $this->browseNodeFactoryMock,
            $this->browseNodeProductTableMock
        );
    }

    public function testGetBrowseNodesAndSalesRanks()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $this->browseNodeProductTableMock->method('selectWhereProductId')->willReturn(
            $this->yieldArrays()
        );

        $browseNodesAndSalesRanks = $this->browseNodesAndSalesRanksService->getBrowseNodesAndSalesRanks(
            $productEntity
        );

        $this->assertSame(
            2,
            count($browseNodesAndSalesRanks)
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodesAndSalesRanks[0]['browse_node']
        );
        $this->assertSame(
            222,
            $browseNodesAndSalesRanks[0]['sales_rank']
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodesAndSalesRanks[1]['browse_node']
        );
        $this->assertSame(
            111,
            $browseNodesAndSalesRanks[1]['sales_rank']
        );
    }

    protected function yieldArrays()
    {
        yield [
            'browse_node_id' => '54321',
            'product_id'     => '12345',
            'sales_rank'     => '222',
            'order'          => '1',
        ];
        yield [
            'browse_node_id' => '314159',
            'product_id'     => '12345',
            'sales_rank'     => '111',
            'order'          => '2',
        ];
    }
}
