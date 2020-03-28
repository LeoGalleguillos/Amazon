<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Newest\BrowseNode;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NumberOfPagesTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeProductTableMock = $this->createMock(
            AmazonTable\BrowseNodeProduct::class
        );

        $this->numberOfPagesService = new AmazonService\Product\Products\Newest\BrowseNode\NumberOfPages(
            $this->browseNodeProductTableMock
        );
    }

    public function test_getNumberOfPages_0results_0pages()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(27182);

        $resultHydrator = new TestHydrator\Result();
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(*)' => '0'],
            ]
        );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeId')
            ->with(27182)
            ->willReturn($resultMock);

        $this->assertSame(
            0,
            $this->numberOfPagesService->getNumberOfPages($browseNodeEntity)
        );
    }

    public function test_getNumberOfPages_123results_2pages()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(27182);

        $resultHydrator = new TestHydrator\Result();
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(*)' => '123'],
            ]
        );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeId')
            ->with(27182)
            ->willReturn($resultMock);

        $this->assertSame(
            2,
            $this->numberOfPagesService->getNumberOfPages($browseNodeEntity)
        );
    }

    public function test_getNumberOfPages_500results_5pages()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(27182);

        $resultHydrator = new TestHydrator\Result();
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(*)' => '500'],
            ]
        );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeId')
            ->with(27182)
            ->willReturn($resultMock);

        $this->assertSame(
            5,
            $this->numberOfPagesService->getNumberOfPages($browseNodeEntity)
        );
    }

    public function test_getNumberOfPages_23456results_100pages()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $browseNodeEntity->setBrowseNodeId(27182);

        $resultHydrator = new TestHydrator\Result();
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator->hydrate(
            $resultMock,
            [
                ['COUNT(*)' => '23456'],
            ]
        );

        $this->browseNodeProductTableMock
            ->expects($this->exactly(1))
            ->method('selectCountWhereBrowseNodeId')
            ->with(27182)
            ->willReturn($resultMock);

        $this->assertSame(
            100,
            $this->numberOfPagesService->getNumberOfPages($browseNodeEntity)
        );
    }
}
