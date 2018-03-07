<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Search;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock    = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productGroupFactoryMock    = $this->createMock(
            AmazonFactory\ProductGroup::class
        );
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\ProductGroup::class
        );
        $this->searchProductGroupTableMock = $this->createMock(
            AmazonTable\Search\ProductGroup::class
        );

        $this->searchProductGroupService = new AmazonService\Search\ProductGroup(
            $this->productFactoryMock,
            $this->productGroupFactoryMock,
            $this->productGroupTableMock,
            $this->searchProductGroupTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Search\ProductGroup::class,
            $this->searchProductGroupService
        );
    }

    public function testGetNumberOfPages()
    {
        $this->assertSame(
            1,
            $this->searchProductGroupService->getNumberOfPages(34)
        );
        $this->assertSame(
            4,
            $this->searchProductGroupService->getNumberOfPages(345)
        );
        $this->assertSame(
            100,
            $this->searchProductGroupService->getNumberOfPages(34500)
        );
    }

    public function testGetProductGroupEntitiesWithSearchTables()
    {
        $this->productGroupTableMock->method('selectWhereSearchTableIsNotNull')->willReturn(
            $this->yieldStuff()
        );

        $generator = $this->searchProductGroupService->getProductGroupEntitiesWithSearchTables();

        $this->assertInstanceOf(
            AmazonEntity\ProductGroup::class,
            $generator->current()
        );

        $generator->next();
        $this->assertInstanceOf(
            AmazonEntity\ProductGroup::class,
            $generator->current()
        );
    }

    protected function yieldStuff()
    {
        yield [
            'search_table' => 'first_search_table',
        ];
        yield [
            'search_table' => 'second_search_table',
        ];
    }
}
