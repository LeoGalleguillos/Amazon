<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class ProductGroupIsValidModifiedTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->asinTable = new AmazonTable\Product\Asin(
            $this->getAdapter(),
            $this->productTable
        );
        $this->productGroupIsValidModifiedTable = new AmazonTable\Product\ProductGroupIsValidModified(
            $this->getAdapter()
        );
    }

    public function test_selectAsinWhereProductGroupAndIsValidEquals1Limit10()
    {
        $this->productTable->insert(
            'ASIN001',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );
        $this->productTable->insert(
            'ASIN002',
            'Title',
            'Different Product Group',
            null,
            null,
            4.99
        );
        $this->productTable->insert(
            'ASIN003',
            'Title',
            'Product Group',
            null,
            null,
            4.99
        );

        $result = $this->productGroupIsValidModifiedTable
            ->selectAsinWhereProductGroupAndIsValidEquals1Limit10('Product Group');
        $array = iterator_to_array($result);
        $this->assertCount(
            2,
            $array
        );
        $this->assertSame(
            'ASIN001',
            $array[0]['asin']
        );
        $this->assertSame(
            'ASIN003',
            $array[1]['asin']
        );

        $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin('ASIN001');

        $result = $this->productGroupIsValidModifiedTable
            ->selectAsinWhereProductGroupAndIsValidEquals1Limit10('Product Group');
        $array = iterator_to_array($result);
        $this->assertCount(
            2,
            $array
        );
        $this->assertSame(
            'ASIN003',
            $array[0]['asin']
        );
        $this->assertSame(
            'ASIN001',
            $array[1]['asin']
        );

        $this->asinTable->updateSetIsValidWhereAsin(0, 'ASIN001');

        $result = $this->productGroupIsValidModifiedTable
            ->selectAsinWhereProductGroupAndIsValidEquals1Limit10('Product Group');
        $array = iterator_to_array($result);
        $this->assertCount(
            1,
            $array
        );
        $this->assertSame(
            'ASIN003',
            $array[0]['asin']
        );
    }

    public function test_selectAsinWhereProductGroupAndIsValidEquals1Limit10_exactlyTenRows()
    {
        for ($iteration = 0; $iteration < 100; $iteration++) {
            $asin = rand(1000, 1000000);
            $this->productTable->insert(
                $asin,
                'Title',
                'Product Group',
                null,
                null,
                4.99
            );
        }
        $result = $this->productGroupIsValidModifiedTable
            ->selectAsinWhereProductGroupAndIsValidEquals1Limit10('Product Group');
        $this->assertCount(
            10,
            $result
        );
    }
}
