<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Brand;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class ConditionallyInsertTest extends TestCase
{
    protected function setUp(): void
    {
        $this->nameExistsServiceMock = $this->createMock(
            AmazonService\Brand\NameExists::class
        );
        $this->brandTableMock = $this->createMock(
            AmazonTable\Brand::class
        );
        $this->urlFriendlyServiceMock = $this->createMock(
            StringService\UrlFriendly::class
        );

        $this->conditionallyInsertService = new AmazonService\Brand\ConditionallyInsert(
            $this->nameExistsServiceMock,
            $this->brandTableMock,
            $this->urlFriendlyServiceMock
        );
    }

    public function test_conditionallyInsert_generatedValue()
    {
        $this->nameExistsServiceMock
            ->expects($this->once())
            ->method('doesNameExist')
            ->with('Name')
            ->willReturn(false)
            ;
        $this->urlFriendlyServiceMock
            ->expects($this->once())
            ->method('getUrlFriendly')
            ->with('Name')
            ->willReturn('name')
            ;
        $resultMock = $this->createMock(
            Result::class
        );
        $resultMock
            ->expects($this->once())
            ->method('getGeneratedValue')
            ->with()
            ->willReturn('1')
            ;
        $this->brandTableMock
            ->expects($this->once())
            ->method('insert')
            ->with('Name', 'name')
            ->willReturn($resultMock)
            ;

        $this->assertEquals(
            $this->conditionallyInsertService->conditionallyInsert('Name'),
            1
        );
    }

    public function test_conditionallyInsert_false()
    {
        $this->nameExistsServiceMock
            ->expects($this->once())
            ->method('doesNameExist')
            ->with('Name')
            ->willReturn(true)
            ;
        $this->urlFriendlyServiceMock
            ->expects($this->exactly(0))
            ->method('getUrlFriendly')
            ;
        $this->brandTableMock
            ->expects($this->exactly(0))
            ->method('insert')
            ;

        $this->assertFalse(
            $this->conditionallyInsertService->conditionallyInsert('Name')
        );
    }
}
