<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductSearchTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productSearchTable = new AmazonTable\ProductSearch(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropTable('product_search');
        $this->createTable('product_search');
        $this->setForeignKeyChecks(1);
    }

    public function test_selectProductIdWhereMatchAgainst_emptyTable_emptyResult()
    {
        $result = $this->productSearchTable->selectProductIdWhereMatchAgainst(
            'the search query'
        );
        $this->assertEmpty(
            iterator_to_array($result)
        );
    }
}