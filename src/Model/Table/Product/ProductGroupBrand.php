<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class ProductGroupBrand
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\Product $productTable
    ) {
        $this->adapter      = $adapter;
        $this->productTable = $productTable;
    }

    public function selectWhereProductGroupBrand(
        string $productGroup,
        string $brand
    ): Result {
        $sql = $this->productTable->getSelect()
            . '
              FROM `product`
             WHERE `product`.`product_group` = ?
               AND `product`.`brand` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT 0, 100
                 ;
        ';
        $parameters = [
            $productGroup,
            $brand,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
