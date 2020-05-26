<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Search;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class NumberOfPagesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->numberOfPagesService = new AmazonService\Product\Products\Search\NumberOfPages();
    }

    public function test_getNumberOfPages_upTo10000Results()
    {
        $this->assertSame(
            0,
            $this->numberOfPagesService->getNumberOfPages(0)
        );
        $this->assertSame(
            1,
            $this->numberOfPagesService->getNumberOfPages(32)
        );
        $this->assertSame(
            50,
            $this->numberOfPagesService->getNumberOfPages(5000)
        );
        $this->assertSame(
            82,
            $this->numberOfPagesService->getNumberOfPages(8174)
        );
        $this->assertSame(
            100,
            $this->numberOfPagesService->getNumberOfPages(10000)
        );
    }

    public function test_getNumberOfPages_moreThan10000Results()
    {
        $this->assertSame(
            100,
            $this->numberOfPagesService->getNumberOfPages(10001)
        );
        $this->assertSame(
            100,
            $this->numberOfPagesService->getNumberOfPages(23456)
        );
        $this->assertSame(
            100,
            $this->numberOfPagesService->getNumberOfPages(67890123)
        );
    }
}
