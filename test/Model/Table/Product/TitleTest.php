<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class TitleTest extends TableTestCase
{
    protected function setUp()
    {
        $this->titleTable = new AmazonTable\Product\Title(
            $this->getAdapter()
        );
        $this->setForeignKeyChecks0();
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks1();
    }

    public function test_selectProductIdWhereMatchAgainst()
    {
        $result = $this->titleTable->selectProductIdWhereMatchAgainst(
            'query'
        );

        $this->assertEmpty(
            iterator_to_array($result)
        );
    }
}
