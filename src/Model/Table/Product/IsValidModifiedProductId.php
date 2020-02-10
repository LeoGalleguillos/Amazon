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

    public function selectAsinWhereIsValidIsNullOrIsValidIs1(
        int $limitRowCount
    ): Generator {
        $sql = '
            SELECT `asin`
              FROM `product`
             WHERE `is_valid` IS NULL OR `is_valid` = 1
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
