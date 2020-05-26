<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Search;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NumberOfResultsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->sanitizedQueryServiceMock = $this->createMock(
            AmazonService\Product\Products\Search\SanitizedQuery::class
        );
        $this->productSearchTableMock = $this->createMock(
            AmazonTable\ProductSearch::class
        );
        $this->numberOfResultsService = new AmazonService\Product\Products\Search\NumberOfResults(
            $this->sanitizedQueryServiceMock,
            $this->productSearchTableMock
        );
    }

    public function test_getNumberOfResults()
    {
        $query          = 'the search query';
        $sanitizedQuery = 'the sanitized query';
        $this->sanitizedQueryServiceMock
            ->expects($this->once())
            ->method('getSanitizedQuery')
            ->with($query)
            ->willReturn($sanitizedQuery);
        $result = $this->createMock(
            LaminasDb\Adapter\Driver\Pdo\Result::class
        );
        $hydrator = new TestHydrator\CountableIterator();
        $hydrator->hydrate(
            $result,
            [
                ['COUNT(*)' => 123]
            ]
        );
        $this->productSearchTableMock
            ->expects($this->once())
            ->method('selectCountWhereMatchAgainst')
            ->with($sanitizedQuery)
            ->willReturn($result);

        $this->assertSame(
            123,
            $this->numberOfResultsService->getNumberOfResults($query)
        );
    }
}
