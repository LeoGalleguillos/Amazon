<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class IsValidCreatedProductIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['browse_node', 'browse_node_product', 'product']);
        $this->setForeignKeyChecks(1);

        $this->browseNodeTable = new AmazonTable\BrowseNode(
            $this->getAdapter()
        );
        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->asinTable = new AmazonTable\Product\Asin(
            $this->getAdapter(),
            $this->productTable
        );
        $this->isValidCreatedProductIdTable = new AmazonTable\Product\IsValidCreatedProductId(
            $this->getAdapter(),
            $this->productTable
        );
    }

    public function test_selectProductIdWhereBrowseNodeName_nonEmptyTable_multipleResults()
    {
        $this->productTable->insertAsin('ASIN001');
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN003');

        $this->browseNodeTable->insertIgnore(12345, 'Hair Extensions');
        $this->browseNodeTable->insertIgnore(54321, 'Apparel');

        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            12345,
            1,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            12345,
            3,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            54321,
            2,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            54321,
            3,
            null,
            1
        );

        $result = $this->isValidCreatedProductIdTable
            ->selectProductIdWhereBrowseNodeName('Hair Extensions');
        $this->assertSame(
            2,
            count($result)
        );
        $array = iterator_to_array($result);
        $this->assertSame(
            '3',
            $array[0]['product_id']
        );
        $this->assertSame(
            '1',
            $array[1]['product_id']
        );
    }

    public function test_selectWhereIsValidEquals1OrderByCreatedDescLimit100_nonEmptyTable_multipleResults()
    {
        $this->productTable->insertAsin('ASIN001');
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN003');

        $result = $this->isValidCreatedProductIdTable
            ->selectWhereIsValidEquals1OrderByCreatedDescLimit100();
        $this->assertSame(
            3,
            count($result)
        );
        $array = iterator_to_array($result);
        $this->assertSame(
            'ASIN003',
            $array[0]['asin']
        );
        $this->assertSame(
            'ASIN002',
            $array[1]['asin']
        );
        $this->assertSame(
            'ASIN001',
            $array[2]['asin']
        );
    }
}