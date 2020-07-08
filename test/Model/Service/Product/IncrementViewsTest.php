<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Test\TableTestCase;

class IncrementViewsTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('product');
        $this->setForeignKeyChecks(1);

        $this->sql = new LaminasDb\Sql\Sql(
            $this->getAdapter()
        );
        $this->incrementViewsService = new AmazonService\Product\IncrementViews(
            $this->sql
        );
    }

    public function test_incrementViews_productDoesNotExist_false()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(1);

        $this->assertFalse(
            $this->incrementViewsService->incrementViews(
                $productEntity
            )
        );
    }

    public function test_incrementViews_productExists_true()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->setProductId(1);

        $insert = $this->sql
            ->insert('product')
            ->values([
                'product_id' => 1,
                'asin'       => 'ASIN001',
                'is_valid'   => 1,
            ]);
        $this->sql
            ->prepareStatementForSqlObject($insert)
            ->execute();

        $this->assertTrue(
            $this->incrementViewsService->incrementViews(
                $productEntity
            )
        );

        $this->incrementViewsService->incrementViews(
            $productEntity
        );

        $select = $this->sql
            ->select('product')
            ->where([
                'product_id' => 1,
            ]);
        $array = $this->sql
            ->prepareStatementForSqlObject($select)
            ->execute()
            ->current();
        $this->assertSame(
            '2',
            $array['views']
        );
    }
}
