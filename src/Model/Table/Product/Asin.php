<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use TypeError;
use Zend\Db\Adapter\Adapter;

class Asin
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

    /**
     * @throws TypeError
     */
    public function selectProductIdWhereAsin(
        string $asin
    ): array {
        $sql = '
            SELECT `product_id`
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function updateSetModifiedToUtcTimestampWhereAsin(string $asin): int
    {
        $sql = '
            UPDATE `product`
               SET `modified` = UTC_TIMESTAMP()
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetInvalidWhereAsin(int $invalid, string $asin): int
    {
        $sql = '
            UPDATE `product`
               SET `invalid` = ?
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $invalid,
            $asin,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
