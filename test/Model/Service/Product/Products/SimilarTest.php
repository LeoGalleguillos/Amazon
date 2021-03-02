<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product\Products;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;
use Laminas\Db\Adapter\Exception\InvalidQueryException;

class SimilarTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productFactoryMock = $this->createMock(
            AmazonFactory\Product::class
        );
        $this->productIdTableMock = $this->createMock(
            AmazonTable\Product\ProductId::class
        );
        $this->productSearchTableMock = $this->createMock(
            AmazonTable\ProductSearch::class
        );
        $this->keepFirstWordsService = new StringService\KeepFirstWords();

        $this->similarService = new AmazonService\Product\Products\Similar(
            $this->productFactoryMock,
            $this->productIdTableMock,
            $this->productSearchTableMock,
            $this->keepFirstWordsService
        );
    }

    public function test_getSimilarProducts()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setTitle('Amazon Title "With Quotes"');

        $productEntities = $this->similarService->getSimilarProducts(
            $productEntity
        );

        $this->assertEmpty(
            iterator_to_array($productEntities)
        );
    }

    public function test_getSimilarProducts_productSearchTableThrowsInvalidQueryException_emptyGenerator()
    {
        $this->productSearchTableMock
            ->method('selectProductIdWhereMatchAgainstLimit')
            ->will($this->throwException(new InvalidQueryException()));

        $productEntity = new AmazonEntity\Product();
        $productEntity->setTitle('Product Title');

        $productEntities = $this->similarService->getSimilarProducts(
            $productEntity
        );

        $this->assertEmpty(
            iterator_to_array($productEntities)
        );
    }
}
