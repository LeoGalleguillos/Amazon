<?php
namespace LeoGalleguillos\AmazonTest\Model\Table;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Table\Api as ApiTable;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/api/';

    /**
     * @var ApiTable
     */
    protected $apiTable;

    protected function setUp()
    {
        $configArray    = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $configArray    = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter  = new Adapter($configArray);
        $this->apiTable = new ApiTable($this->adapter);

        $this->dropTable();
        $this->createTable();
    }

    protected function dropTable()
    {
        $sql    = file_get_contents($this->sqlPath . 'drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTable()
    {
        $sql    = file_get_contents($this->sqlPath . 'create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(ApiTable::class, $this->apiTable);
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

    public function selectValueWhereKey()
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
