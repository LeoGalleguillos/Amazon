<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;

class ProductFeatureTest extends TableTestCase
{
    protected function setUp()
    {
        $this->productFeatureTable = new AmazonTable\ProductFeature(
            $this->getAdapter()
        );

        $this->dropAndCreateTable('product_feature');
    }

    public function testSelectWhereProductId()
    {
        $generator = $this->productFeatureTable->selectWhereProductId(
            12345
        );
        $this->assertEmpty(
            iterator_to_array($generator)
        );
    }
}
