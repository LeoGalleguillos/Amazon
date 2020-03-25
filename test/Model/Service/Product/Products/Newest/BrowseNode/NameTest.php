<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products\Newest\BrowseNode;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->isValidCreatedProductIdTableMock = $this->createMock(
            AmazonTable\Product\IsValidCreatedProductId::class
        );

        $this->nameService = new AmazonService\Product\Products\Newest\BrowseNode\Name(
            $this->productFactoryMock,
            $this->isValidCreatedProductIdTableMock
        );
    }

    public function test_getNewestProducts_emptyResult_zeroProducts()
    {
        $this->assertEmpty(
            iterator_to_array($this->nameService->getNewestProducts('Hair Extensions'))
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
                    'product_id' => '2',
                ],
                [
                    'product_id' => '1',
                ],
            ]
        );

        $this->isValidCreatedProductIdTableMock
            ->expects($this->exactly(1))
            ->method('selectProductIdWhereBrowseNodeName')
            ->willReturn($resultMock);

        $productEntity1 = new AmazonEntity\Product();
        $productEntity2 = new AmazonEntity\Product();

        $this->productFactoryMock
            ->expects($this->exactly(2))
            ->method('buildFromProductId')
            ->withConsecutive(
                ['2'],
                ['1']
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
            iterator_to_array($this->nameService->getNewestProducts('Hair Extensions'))
        );
    }
}
