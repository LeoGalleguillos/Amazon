<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class ProductGroupTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productGroupTableMock = $this->createMock(
            AmazonTable\Product\ProductGroup::class
        );

        $this->productGroupService = new AmazonService\Product\Products\ProductGroup(
            $this->productFactoryMock,
            $this->productGroupTableMock
        );
    }

    public function test_getProductEntities_zeroProducts()
    {
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity
            ->setName('Name')
            ->setSlug('slug')
            ;
        $this->productGroupTableMock
            ->expects($this->once())
            ->method('selectWhereProductGroup')
            ->with(
                'Name',
                0,
                100
            );
        $result = $this->productGroupService->getProductEntities(
            $productGroupEntity,
            1
        );
        $this->assertEmpty(
            iterator_to_array($result)
        );
    }

    public function test_getProductEntities_multipleProducts()
    {
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity
            ->setName('Name')
            ->setSlug('slug')
            ;

        $resultMock = $this->createMock(
            Result::class
        );
        $resultHydrator = new TestHydrator\CountableIterator();
        $resultHydrator->hydrate(
            $resultMock,
            [
                [
                    'asin' => 'ASIN321',
                ],
                [
                    'asin' => 'ASIN123',
                ],
            ]
        );

        $this->productGroupTableMock
            ->expects($this->exactly(1))
            ->method('selectWhereProductGroup')
            ->with('Name', 0, 100)
            ->willReturn($resultMock);

        $productEntity1 = new AmazonEntity\Product();
        $productEntity2 = new AmazonEntity\Product();

        $this->productFactoryMock
            ->expects($this->exactly(2))
            ->method('buildFromArray')
            ->withConsecutive(
                [['asin' => 'ASIN321']],
                [['asin' => 'ASIN123']]
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
            iterator_to_array($this->productGroupService->getProductEntities($productGroupEntity))
        );
    }
}
