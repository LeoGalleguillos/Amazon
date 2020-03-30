<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;
use Zend\Db\Adapter\Adapter;

class Asin
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\Product $productTable
    ) {
        $this->adapter      = $adapter;
        $this->productTable = $productTable;
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

    public function selectWhereAsin(string $asin): Result
    {
        $sql = $this->productTable->getSelect()
             . '
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters);
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

    public function updateSetIsValidWhereAsin(int $isValid, string $asin): Result
    {
        $sql = '
            UPDATE `product`
               SET `is_valid` = ?
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $isValid,
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function updateSetParentAsinWhereAsin(
        string $parentAsin,
        string $asin
    ): Result {
        $sql = '
            UPDATE `product`
               SET `parent_asin` = ?
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $parentAsin,
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
