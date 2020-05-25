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

    public function test_selectCountWhereMatchAgainst_emptyTable_0Results()
    {
        $result = $this->productSearchTable->selectCountWhereMatchAgainst(
            'the search query'
        );
        $this->assertSame(
            '0',
            $result->current()['COUNT(*)']
        );
    }

    public function test_selectProductIdWhereMatchAgainstLimit_emptyTable_emptyResult()
    {
        $result = $this->productSearchTable->selectProductIdWhereMatchAgainstLimit(
            'the search query',
            0,
            100
        );
        $this->assertEmpty(
            iterator_to_array($result)
        );
    }
}
