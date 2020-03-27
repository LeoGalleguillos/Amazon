<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SimilarRetrievedModifiedProductId
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

    public function selectOrderBySimilarRetrievedAscModifiedAscProductIdAscLimit1(): Result
    {
        $sql = $this->productTable->getSelect()
            . '
              FROM `product`
             ORDER
                BY `product`.`similar_retrieved` ASC
                 , `product`.`modified` ASC
                 , `product`.`product_id` ASC
             LIMIT 1
                 ;
        ';
        return $this->adapter->query($sql)->execute();
    }
}
