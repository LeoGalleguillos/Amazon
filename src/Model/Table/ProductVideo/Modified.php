<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use Zend\Db\Adapter\Adapter;

class Modified
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->adapter           = $adapter;
        $this->productVideoTable = $productVideoTable;
    }

    /**
     * @yield array
     */
    public function selectWhereModifiedIsNullAndBrowseNodeIdIsNullLimit(
        int $limit
    ): Generator {
        $sql = $this->productVideoTable->getSelect()
             . '
              FROM `product_video`

              LEFT
              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `product_video`.`modified` IS NULL
               AND `browse_node_product`.`browse_node_id` IS NULL

             LIMIT ?
        ';
        $parameters = [
            $limit,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
