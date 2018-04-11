<?php
namespace LeoGalleguillos\AmazonTest\Model\Table\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\AmazonTest as AmazonTest;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class HashtagsRetrievedTest extends AmazonTest\TableCase
{
    protected function setUp()
    {
        parent::setup();

        $this->hashtagsRetrievedTable = new AmazonTable\Product\HashtagsRetrieved(
            $this->adapter
        );

        $this->setForeignKeyChecks0();
        $this->dropTable();
        $this->createTable();
        $this->setForeignKeyChecks1();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product/drop.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents(
            $this->sqlDirectory . 'leogalle_test/product/create.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonTable\Product\HashtagsRetrieved::class,
            $this->hashtagsRetrievedTable
        );
    }

    public function testSelectWhereProductId()
    {
        try {
            $this->hashtagsRetrievedTable->selectWhereProductId(1);
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Hashtags have never been retrieved.',
                $exception->getMessage()
            );
        }
    }

    public function testUpdateWhereProductId()
    {
        $this->assertSame(
            0,
            $this->hashtagsRetrievedTable->updateWhereProductId(1)
        );
    }
}
