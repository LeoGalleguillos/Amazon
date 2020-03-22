<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\TableTestCase;
use TypeError;

class BrowseNodeTest extends TableTestCase
{
    protected function setUp()
    {
        $this->browseNodeTable = new AmazonTable\BrowseNode(
            $this->getAdapter()
        );
        $this->browseNodeProductTable = new AmazonTable\BrowseNodeProduct(
            $this->getAdapter()
        );

        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTables(['browse_node', 'browse_node_product']);
        $this->setForeignKeyChecks(1);
    }

    public function testInsertIgnore()
    {
        $this->assertSame(
            1,
            $this->browseNodeTable->insertIgnore(1, 'name')
        );
        $this->assertSame(
            0,
            $this->browseNodeTable->insertIgnore(1, 'name')
        );
        $this->assertSame(
            1,
            $this->browseNodeTable->insertIgnore(5, 'name')
        );
    }

    public function test_selectNameWhereProductIdLimit1_emptyTables()
    {
        $result = $this->browseNodeTable->selectNameWhereProductIdLimit1(12345);
        $this->assertEmpty($result);
    }

    public function test_selectNameWhereProductIdLimit1_oneRow()
    {
        $this->setForeignKeyChecks(0);
        $this->browseNodeTable->insertIgnore(
            314159,
            'Browse Node #314159'
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            314159,
            12345,
            null,
            1
        );

        $result = $this->browseNodeTable->selectNameWhereProductIdLimit1(12345);
        $this->assertSame(
            'Browse Node #314159',
            $result->current()['name']
        );
    }

    public function test_selectNameWhereProductIdLimit1_multipleRows()
    {
        $this->setForeignKeyChecks(0);
        $this->browseNodeTable->insertIgnore(
            1618,
            'Browse Node #1618'
        );
        $this->browseNodeTable->insertIgnore(
            271828,
            'Browse Node #271828'
        );
        $this->browseNodeTable->insertIgnore(
            314159,
            'Browse Node #314159'
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            271828,
            12345,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            1618,
            12345,
            null,
            1
        );
        $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
            31419,
            12345,
            null,
            1
        );

        $result = $this->browseNodeTable->selectNameWhereProductIdLimit1(12345);
        $this->assertSame(
            'Browse Node #271828',
            $result->current()['name']
        );
    }

    public function testSelectWhereBrowseNodeId()
    {
        try {
            $array = $this->browseNodeTable->selectWhereBrowseNodeId(12345);
            $this->fail();
        } catch (TypeError $typeError) {
            $this->assertSame(
                'Return value of',
                substr($typeError->getMessage(), 0, 15)
            );
        }

        $this->browseNodeTable->insertIgnore(12345, 'Browse Node Name');
        $this->assertSame(
            [
                'browse_node_id' => '12345',
                'name' => 'Browse Node Name',
            ],
            $this->browseNodeTable->selectWhereBrowseNodeId(12345)
        );
    }

    public function testSelectWhereName()
    {
        $generator = $this->browseNodeTable->selectWhereName('Name');
        $this->assertSame(
            [],
            iterator_to_array($generator)
        );

        $this->browseNodeTable->insertIgnore(98, 'Foo');
        $this->browseNodeTable->insertIgnore(35791, 'Bar');
        $this->browseNodeTable->insertIgnore(2468, 'Foo');

        $generator = $this->browseNodeTable->selectWhereName('Foo');
        $this->assertSame(
            [
                [
                    'browse_node_id' => '98',
                    'name' => 'Foo'
                ],
                [
                    'browse_node_id' => '2468',
                    'name' => 'Foo'
                ],
            ],
            iterator_to_array($generator)
        );
    }
}
