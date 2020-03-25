<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class IsValidModifiedProductId
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

    public function selectWhereIsValidEquals1OrderByModifiedDescLimit100(): Result
    {
        $sql = $this->productTable->getSelect()
             . '
              FROM `product`
             WHERE `is_valid` = 1
             ORDER
                BY `modified` DESC
                 , `product_id` DESC
             LIMIT 100
                 ;
        ';
        return $this->adapter->query($sql)->execute();
    }

}
