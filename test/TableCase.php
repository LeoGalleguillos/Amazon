<?php
namespace LeoGalleguillos\AmazonTest;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Memcached\Model\Service as MemcachedService;
use Zend\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;

class TableCase extends TestCase
{
    protected $adapter;
    protected $sqlDirectory;

    protected function setUp()
    {
        $this->sqlDirectory = $_SERVER['PWD'] . '/sql/';

        $configArray        = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $configArray        = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter      = new Adapter($configArray);
    }

    protected function setForeignKeyChecks0()
    {
        $sql = file_get_contents(
            $this->sqlDirectory . 'SetForeignKeyChecks0.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }

    protected function setForeignKeyChecks1()
    {
        $sql = file_get_contents(
            $this->sqlDirectory . 'SetForeignKeyChecks1.sql'
        );
        $result = $this->adapter->query($sql)->execute();
    }
}
