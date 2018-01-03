<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;

class Products
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    /**
     * @yield string
     */
    public function selectAsinWhereInStockEquals1()
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`in_stock` = 1
             LIMIT 100
                 ;
        ';
        $results = $this->adapter->query($sql)->execute();

        foreach ($results as $row) {
            yield $row['asin'];
        }
    }

    /**
     * Select ASIN where modified is greater than or equal to.
     *
     * @yield string
     */
    public function selectAsinWhereModifiedGreaterThanOrEqualTo($datetime)
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`modified` >= ?
             ORDER
                BY `product`.`modified` ASC
             LIMIT 1000
                 ;
        ';
        $results = $this->adapter->query($sql, [$datetime]);

        foreach ($results as $row) {
            yield $row['asin'];
        }
    }
}
