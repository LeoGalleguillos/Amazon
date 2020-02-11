<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use Zend\Db\Adapter\Adapter;

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

    /**
     * This method can be deprecated once all `is_valid` values are updated to
     * either 1 or 0.
     */
    public function selectAsinWhereIsValidIsNullLimitRowCount(
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `asin`
              FROM `product`
             WHERE `is_valid` IS NULL
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
