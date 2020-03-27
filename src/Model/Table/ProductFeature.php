<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class ProductFeature
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

    public function deleteWhereProductId(int $productId): Result
    {
        $sql = '
            DELETE
              FROM `product_feature`
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function selectWhereProductId(int $productId): Generator
    {
        $sql = '
            SELECT `product_feature`.`product_id`
                 , `product_feature`.`feature`
              FROM `product_feature`
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function insert(
        int $productId,
        string $feature
    ): int {
        $sql = '
            INSERT
              INTO `product_feature` (`product_id`, `feature`)
            VALUES (?, ?)
           ;
        ';
        $parameters = [
            $productId,
            $feature,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
