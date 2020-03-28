<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase as TableTestCase;

class BrowseNodeIdTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['browse_node_product', 'product']);
        $this->setForeignKeyChecks(1);

        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );
        $this->productTable = new AmazonTable\Product(
            $this->getAdapter()
        );
        $this->browseNodeIdTable = new AmazonTable\Product\BrowseNodeId(
            $this->getAdapter()
        );
    }

    public function test_selectProductIdWhereBrowseNodeId_multipleRows_multipleResults()
    {
        $this->setForeignKeyChecks(0);
        $this->productTable->insertAsin('ASIN001');
        $this->productTable->insertAsin('ASIN002');
        $this->productTable->insertAsin('ASIN003');

        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            12345,
            1,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            54321,
            3,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            11111,
            2,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            54321,
            1,
            null,
            2
        );

        $result = $this->browseNodeIdTable
            ->selectProductIdWhereBrowseNodeId(
                54321
            );
        $this->assertSame(
            '3',
            $result->current()['product_id']
        );
        $result->next();
        $this->assertSame(
            '1',
            $result->current()['product_id']
        );
    }
}
