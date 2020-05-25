<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Search;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class SanitizedQueryTest extends TestCase
{
    protected function setUp()
    {
        $this->keepFirstWordsServiceMock = $this->createMock(
            StringService\KeepFirstWords::class
        );
        $this->sanitizedQueryService = new AmazonService\Product\Products\Search\SanitizedQuery(
            $this->keepFirstWordsServiceMock
        );
    }

    public function test_getSanitizedQuery()
    {
        $query = 'this "is" the search query';
        $this->keepFirstWordsServiceMock
            ->expects($this->once())
            ->method('keepFirstWords')
            ->with($query, 3)
            ->willReturn('this "is" the');
        $sanitizedQuery = $this->sanitizedQueryService->getSanitizedQuery(
            $query
        );
        $this->assertSame(
            'this is the',
            $sanitizedQuery
        );
    }
}
