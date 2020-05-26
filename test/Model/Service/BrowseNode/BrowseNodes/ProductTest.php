<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class ProductTest extends TestCase
{
    protected function setUp(): void
    {
        $this->browseNodeFactoryMock = $this->createMock(
            AmazonFactory\BrowseNode::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );

        $this->productService = new AmazonService\BrowseNode\BrowseNodes\Product(
            $this->browseNodeFactoryMock,
            $this->browseNodeProductTableMock
        );
    }

    public function testGetBrowseNodes()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $this->browseNodeProductTableMock->method('selectWhereProductId')->willReturn(
            $this->yieldArrays()
        );

        $browseNodeEntities = $this->productService->getBrowseNodes(
            $productEntity
        );

        $this->assertSame(
            2,
            count($browseNodeEntities)
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodeEntities[0]
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodeEntities[1]
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
