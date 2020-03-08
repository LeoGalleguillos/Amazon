<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductBannedTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productBannedTable = new AmazonTable\ProductBanned(
            $this->getAdapter()
        );

        $this->dropAndCreateTable('product_banned');
    }

    public function test_insertIgnore_newAsin_affectedRows1()
    {
        $result = $this->productBannedTable->insertIgnore('ASIN001');
        $this->assertSame(
            1,
            $result->getAffectedRows()
        );
    }

    public function test_insertIgnore_duplicateAsin_affectedRows0()
    {
        $result = $this->productBannedTable->insertIgnore('ASIN001');
        $result = $this->productBannedTable->insertIgnore('ASIN001');
        $this->assertSame(
            0,
            $result->getAffectedRows()
        );
    }

    public function test_selectCountWhereAsin_asinExists_1()
    {
        $this->productBannedTable->insertIgnore('ASIN00123');
        $result = $this->productBannedTable->selectCountWhereAsin('ASIN00123');
        $this->assertSame(
            '1',
            $result->current()['COUNT(*)']
        );
    }

    public function test_selectCountWhereAsin_asinDoesNotExist_0()
    {
        $result = $this->productBannedTable->selectCountWhereAsin('ASIN987');
        $this->assertSame(
            '0',
            $result->current()['COUNT(*)']
        );
    }
}
