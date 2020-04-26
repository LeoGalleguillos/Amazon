<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Newest\BrowseNode\Name;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NumberOfPagesTest extends TestCase
{
    protected function setUp()
    {
        $this->isValidCreatedProductIdTableMock = $this->createMock(
            AmazonTable\Product\IsValidCreatedProductId::class
        );

        $this->numberOfPagesService = new AmazonService\Product\Products\Newest\BrowseNode\Name\NumberOfPages(
            $this->isValidCreatedProductIdTableMock
        );
    }

    public function test_getNumberOfPages_0Results_0Pages()
    {
        $resultHydrator = new TestHydrator\CountableIterator();

        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(DISTINCT `product`.`product_id`)' => '0'],
            ]
        );

        $this->isValidCreatedProductIdTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeNameLimit')
            ->with('Video Games')
            ->willReturn($resultMock);

        $this->assertSame(
            0,
            $this->numberOfPagesService->getNumberOfPages('Video Games')
        );
    }

    public function test_getNumberOfPages_123Results_2Pages()
    {
        $resultHydrator = new TestHydrator\CountableIterator();

        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(DISTINCT `product`.`product_id`)' => '123'],
            ]
        );

        $this->isValidCreatedProductIdTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeNameLimit')
            ->with('Video Games')
            ->willReturn($resultMock);

        $this->assertSame(
            2,
            $this->numberOfPagesService->getNumberOfPages('Video Games')
        );
    }

    public function test_getNumberOfPages_500Results_5Pages()
    {
        $resultHydrator = new TestHydrator\CountableIterator();

        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(DISTINCT `product`.`product_id`)' => '500'],
            ]
        );

        $this->isValidCreatedProductIdTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeNameLimit')
            ->with('Video Games')
            ->willReturn($resultMock);

        $this->assertSame(
            5,
            $this->numberOfPagesService->getNumberOfPages('Video Games')
        );
    }
}
