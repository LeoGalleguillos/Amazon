<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroupIsValidSimilarRetrieved
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

    public function selectWhereProductGroupIsValid1OrderBySimilarRetrievedAscProductIdAscLimit1(
        string $productGroup
    ): Result {
        $sql = $this->productTable->getSelect()
            . '
              FROM `product`
             WHERE `product_group` = ?
               AND `is_valid` = 1
             ORDER
                BY `product`.`similar_retrieved` ASC
                 , `product`.`product_id` ASC
             LIMIT 1
                 ;
        ';
        $parameters = [
            $productGroup,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
