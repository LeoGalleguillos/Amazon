<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use Zend\Db\Adapter\Adapter;

class ModifiedProductId
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

    public function selectAsinOrderByModifiedIsNullDescModifiedAscProductIdAscLimitRowCount(
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `asin`
              FROM `product`
             ORDER
                BY `modified` IS NULL DESC
                 , `modified` ASC
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
