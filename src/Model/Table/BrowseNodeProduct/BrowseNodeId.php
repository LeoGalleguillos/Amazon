<?php
namespace LeoGalleguillos\Amazon\Model\Table\BrowseNodeProduct;

use Generator;
use Laminas\Db\Adapter\Adapter;

class BrowseNodeId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function selectProductIdWhereBrowseNodeIdIsNull(): Generator
    {
        $sql = '
            SELECT `product_video`.`product_id`

              FROM `product_video`

              LEFT
              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `browse_node_product`.`browse_node_id IS NULL

             LIMIT 1
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array['product_id'];
        };
    }
}
