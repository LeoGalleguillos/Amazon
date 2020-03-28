<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class BrowseNodeId
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

    public function selectProductIdWhereBrowseNodeId(
        int $browseNodeId
    ): Result {
        $sql = '
            SELECT `product_id`
              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `browse_node_product`.`browse_node_id` = ?

             ORDER
                BY `product`.`product_id` DESC

             LIMIT 100
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
