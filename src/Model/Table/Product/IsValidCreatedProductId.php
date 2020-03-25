<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class IsValidCreatedProductId
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

    public function selectProductIdWhereBrowseNodeNameLimit(
        string $browseNodeName,
        int $limitOffset,
        int $limitRowCount
    ): Result {
        $sql = '
            SELECT `product_id`
              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `browse_node`.`name` = ?
               AND `product`.`is_valid` = 1

             GROUP
                BY `product_id`

             ORDER
                BY `product`.`created` DESC
                 , `product`.`product_id` DESC

             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $browseNodeName,
            $limitOffset,
            $limitRowCount,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function selectWhereIsValidEquals1OrderByCreatedDescLimit100(): Result
    {
        $sql = $this->productTable->getSelect()
             . '
              FROM `product`
             WHERE `is_valid` = 1
             ORDER
                BY `created` DESC
                 , `product_id` DESC
             LIMIT 100
                 ;
        ';
        return $this->adapter->query($sql)->execute();
    }
}
