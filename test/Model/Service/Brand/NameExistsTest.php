<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Brand;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\Hydrator as LaminasTestHydrator;
use PHPUnit\Framework\TestCase;

class NameExistsTest extends TestCase
{
    protected function setUp(): void
    {
        $this->brandTableMock = $this->createMock(AmazonTable\Brand::class);

        $this->nameExistsService = new AmazonService\Brand\NameExists(
            $this->brandTableMock
        );
    }

    public function test_doesNameExist_true()
    {
        $resultMock = $this->createMock(
            Result::class
        );
        $hydrator = new LaminasTestHydrator\CountableIterator();
        $hydrator->hydrate(
            $resultMock,
            [
                [
                    'brand_id' => '1',
                    'name'     => 'Name',
                    'slug'     => 'slug',
                ],
            ]
        );
        $this->brandTableMock
            ->expects($this->once())
            ->method('selectWhereName')
            ->with('Name')
            ->willReturn($resultMock)
            ;

        $this->assertTrue(
            $this->nameExistsService->doesNameExist('Name')
        );
    }

    public function test_doesNameExist_false()
    {
        $resultMock = $this->createMock(
            Result::class
        );
        $hydrator = new LaminasTestHydrator\CountableIterator();
        $hydrator->hydrate(
            $resultMock,
            [
            ]
        );
        $this->brandTableMock
            ->expects($this->once())
            ->method('selectWhereName')
            ->with('Name')
            ->willReturn($resultMock)
            ;

        $this->assertFalse(
            $this->nameExistsService->doesNameExist('Name')
        );
    }
}
