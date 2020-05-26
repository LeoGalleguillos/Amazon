<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use LeoGalleguillos\Amazon\Model\Table\Api as ApiTable;
use LeoGalleguillos\Test\TableTestCase;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ApiTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->apiTable = new ApiTable(
            $this->getAdapter()
        );

        $this->dropTable('api');
        $this->createTable('api');
    }

    public function testInsertOnDuplicateKeyUpdate()
    {
        $this->apiTable->insertOnDuplicateKeyUpdate(
            'key',
            'value'
        );
        $this->assertEquals(
            'value',
            $this->apiTable->selectValueWhereKey('key')
        );

        $this->apiTable->insertOnDuplicateKeyUpdate(
            'another key',
            'another value'
        );
        $this->assertEquals(
            'another value',
            $this->apiTable->selectValueWhereKey('another key')
        );

        $this->apiTable->insertOnDuplicateKeyUpdate(
            'key',
            'new value'
        );
        $this->assertEquals(
            'new value',
            $this->apiTable->selectValueWhereKey('key')
        );
    }

    public function testSelectValueWhereKey()
    {
        $key   = 'key';
        $value = 'value';
        $this->apiTable->insertOnDuplicateKeyUpdate(
            $key,
            $value
        );
        $this->assertEquals(
            $value,
            $this->apiTable->selectValueWhereKey($key)
        );

        $key   = 'another key';
        $value = 'another value';
        $this->apiTable->insertOnDuplicateKeyUpdate(
            $key,
            $value
        );
        $this->assertEquals(
            $value,
            $this->apiTable->selectValueWhereKey($key)
        );
    }
}
