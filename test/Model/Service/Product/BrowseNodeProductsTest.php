<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;
use TypeError;

class BrowseNodeProductsTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeFactoryMock = $this->createMock(
            AmazonFactory\BrowseNode::class
        );
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );

        $this->browseNodeProductsService = new AmazonService\Product\BrowseNodeProducts(
            $this->browseNodeFactoryMock,
            $this->browseNodeProductTableMock
        );
    }

    public function testGetBrowseNodeProducts()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(12345);

        $this->browseNodeProductTableMock->method('selectWhereProductId')->willReturn(
            $this->yieldArrays()
        );

        $browseNodeProducts = $this->browseNodeProductsService->getBrowseNodeProducts(
            $productEntity
        );

        $this->assertSame(
            2,
            count($browseNodeProducts)
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodeProducts[0]->getBrowseNode()
        );
        $this->assertSame(
            222,
            $browseNodeProducts[0]->getSalesRank()
        );
        $this->assertInstanceOf(
            AmazonEntity\BrowseNode::class,
            $browseNodeProducts[1]->getBrowseNode()
        );

        $this->expectException(TypeError::class);
        $browseNodeProducts[1]->getSalesRank();
    }

    public function testGetBrowseNodeProducts_BrowseNodeProductsArrayIsAlreadySet()
    {
        $this->browseNodeProductTableMock->method('selectWhereProductId')->willReturn(
            $this->yieldArrays()
        );

        $productEntity = new AmazonEntity\Product();
        $browseNodeProducts = [];
        $productEntity->setBrowseNodeProducts($browseNodeProducts);

        $this->assertSame(
            $browseNodeProducts,
            $this->browseNodeProductsService->getBrowseNodeProducts($productEntity)
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
            'order'          => '2',
        ];
    }
}
