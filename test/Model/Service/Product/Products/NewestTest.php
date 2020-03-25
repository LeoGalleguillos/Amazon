<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NewestTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->isValidCreatedProductIdTableMock = $this->createMock(
            AmazonTable\Product\IsValidCreatedProductId::class
        );

        $this->newestService = new AmazonService\Product\Products\Newest(
            $this->productFactoryMock,
            $this->isValidCreatedProductIdTableMock
        );
    }

    public function test_getNewestProducts_emptyResult_zeroProducts()
    {
        $this->assertEmpty(
            iterator_to_array($this->newestService->getNewestProducts())
        );
    }

    public function test_getNewestProducts_nonEmptyResult_multipleProducts()
    {
        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator = new TestHydrator\Result();
        $resultHydrator->hydrate(
            $resultMock,
            [
                [
                    'asin' => 'ASIN002',
                ],
                [
                    'asin' => 'ASIN001',
                ],
            ]
        );

        $this->isValidCreatedProductIdTableMock
            ->method('selectWhereIsValidEquals1OrderByCreatedDescLimit100')
            ->willReturn($resultMock);

        $productEntity1 = new AmazonEntity\Product();
        $productEntity2 = new AmazonEntity\Product();

        $this->productFactoryMock
            ->expects($this->exactly(2))
            ->method('buildFromArray')
            ->withConsecutive(
                [['asin' => 'ASIN002']],
                [['asin' => 'ASIN001']]
            )
            ->will(
                $this->onConsecutiveCalls(
                    $productEntity1,
                    $productEntity2
                )
            );

        $this->assertSame(
            [
                $productEntity1,
                $productEntity2
            ],
            iterator_to_array($this->newestService->getNewestProducts())
        );
    }
}
