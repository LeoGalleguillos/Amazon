<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class ProductBanned
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    public function insertIgnore(string $asin): Result
    {
        $sql = '
            INSERT IGNORE
              INTO `product_banned` (`asin`)
            VALUES (?)
                 ;
        ';

        $parameters = [
            $asin,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters);
    }

    public function selectCountWhereAsin(string $asin): Result
    {
        $sql = '
            SELECT COUNT(*)
              FROM `product_banned`
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
