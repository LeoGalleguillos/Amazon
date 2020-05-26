<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class BannedTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productBannedTableMock = $this->createMock(
            AmazonTable\ProductBanned::class
        );

        $this->bannedService = new AmazonService\Product\Banned(
            $this->productBannedTableMock
        );
    }

    public function test_isBanned_countIs1_true()
    {
        $this->resultMock = $this->createMock(
            Result::class
        );
        $this->resultMock
            ->method('current')
            ->will(
                $this->onConsecutiveCalls(
                    ['COUNT(*)' => 1]
                )
            );
        $this->resultMock
            ->method('key')
            ->will(
                $this->onConsecutiveCalls(
                    0
                )
            );
        $this->resultMock
            ->method('valid')
            ->will(
                $this->onConsecutiveCalls(
                    true,
                    false
                )
            );

        $this->productBannedTableMock
            ->method('selectCountWhereAsin')
            ->willReturn(
                $this->resultMock
            );

        $this->assertTrue(
            $this->bannedService->isBanned('ASIN001')
        );
    }

    public function test_isBanned_countIs0_false()
    {
        $this->resultMock = $this->createMock(
            Result::class
        );
        $this->resultMock
            ->method('current')
            ->will(
                $this->onConsecutiveCalls(
                    ['COUNT(*)' => 0]
                )
            );
        $this->resultMock
            ->method('key')
            ->will(
                $this->onConsecutiveCalls(
                    0
                )
            );
        $this->resultMock
            ->method('valid')
            ->will(
                $this->onConsecutiveCalls(
                    true,
                    false
                )
            );

        $this->productBannedTableMock
            ->method('selectCountWhereAsin')
            ->willReturn(
                $this->resultMock
            );

        $this->assertFalse(
            $this->bannedService->isBanned('ASIN001')
        );
    }
}
