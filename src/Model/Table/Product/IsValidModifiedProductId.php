<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class IsValidModifiedProductId
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

    public function selectAsinWhereIsValidEquals1LimitRowCount(
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `asin`
              FROM `product`
             WHERE `is_valid` = 1
             ORDER
                BY `modified` ASC
                 , `product_id` ASC
             LIMIT ?
                 ;
        ';
        $parameters = [
            $limitRowCount,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
