<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class ProductGroupBindingBrandTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productGroupBindingBrandTableMock = $this->createMock(
            AmazonTable\Product\ProductGroupBindingBrand::class
        );

        $this->productGroupBindingBrandService = new AmazonService\Product\Products\ProductGroupBindingBrand(
            $this->productFactoryMock,
            $this->productGroupBindingBrandTableMock
        );
    }

    public function test_getProductEntities_zeroProducts()
    {
        $productGroupEntity = (new AmazonEntity\ProductGroup())
            ->setName('Name')
            ->setSlug('slug')
            ;
        $bindingEntity = (new AmazonEntity\Binding())
            ->setName('Name')
            ->setSlug('slug')
            ;
        $brandEntity = (new AmazonEntity\Brand())
            ->setName('Name')
            ->setSlug('slug')
            ;

        $result = $this->productGroupBindingBrandService->getProductEntities(
            $productGroupEntity,
            $bindingEntity,
            $brandEntity
        );
        $this->assertEmpty(
            iterator_to_array($result)
        );
    }

    public function test_getProductEntities_multipleProducts()
    {
        $productGroupEntity = (new AmazonEntity\ProductGroup())
            ->setName('Product Group Name')
            ->setSlug('slug')
            ;
        $bindingEntity = (new AmazonEntity\Binding())
            ->setName('Binding Name')
            ->setSlug('slug')
            ;
        $brandEntity = (new AmazonEntity\Brand())
            ->setName('Brand Name')
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

        $this->productGroupBindingBrandTableMock
            ->expects($this->exactly(1))
            ->method('selectWhereProductGroupBindingBrand')
            ->with('Product Group Name', 'Binding Name', 'Brand Name')
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
            iterator_to_array(
                $this->productGroupBindingBrandService->getProductEntities(
                    $productGroupEntity,
                    $bindingEntity,
                    $brandEntity
                )
            )
        );
    }
}
