<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\Product $productTable
    ) {
        $this->adapter      = $adapter;
        $this->productTable = $productTable;
    }

    public function selectWhereProductGroup(
        string $productGroup
    ): Result {
        $sql = $this->productTable->getSelect()
            . '
              FROM `product`
             WHERE `product`.`product_group` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT 0, 100
                 ;
        ';
        $parameters = [
            $productGroup,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
