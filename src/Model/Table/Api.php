<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Laminas\Db\Adapter\Adapter;

class Api
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function insertOnDuplicateKeyUpdate($key, $value)
    {
        $sql = '
            INSERT
              INTO `api` (`key`, `value`)
            VALUES (?, ?)
                ON DUPLICATE KEY UPDATE `value` = ?
                 ;
        ';
        $parameters = [
            $key,
            $value,
            $value
        ];
        return $this->adapter
                    ->query($sql, $parameters)
                    ->getGeneratedValue();
    }

    /**
     * @return string|bool
     */
    public function selectValueWhereKey($key)
    {
        $sql = '
            SELECT `value`
              FROM `api`
             WHERE `key` = ?
                 ;
        ';
        $arrayObject = $this->adapter->query($sql, [$key])->current();
        return $arrayObject['value'];
    }
}
