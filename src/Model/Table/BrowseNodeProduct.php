<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;

class BrowseNodeProduct
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

    public function insertIgnore(
        int $browseNodeId,
        int $productId
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `browse_node_product` (
                       `browse_node_id`
                     , `product_id`
                   )
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $browseNodeId,
            $productId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function selectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdLimit1(
        int $browseNodeId
    ): int {
        $sql = '
            SELECT `product`.`product_id`

              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `similar_retrieved` IS NULL
               AND `browse_node_id` = ?

             LIMIT 1
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['product_id'];
    }

    public function selectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdLimit1(
        int $browseNodeId
    ): int {
        $sql = '
            SELECT `product`.`product_id`

              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `video_generated` IS NULL
               AND `browse_node_id` = ?

             LIMIT 1
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['product_id'];
    }
}
