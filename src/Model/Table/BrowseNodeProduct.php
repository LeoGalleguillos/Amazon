<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Exception;
use Generator;
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

    public function insertOnDuplicateKeyUpdate(
        int $browseNodeId,
        int $productId,
        int $order
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `browse_node_product` (
                       `browse_node_id`
                     , `product_id`
                     , `order`
                   )
            VALUES (?, ?, ?)
                ON DUPLICATE KEY
            UPDATE `order` = ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
            $productId,
            $order,
            $order,
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

    public function selectProductIdWhereSimilarRetrievedIsNullAndBrowseNodeIdInLimit1(
        array $browseNodeIds
    ): int {
        if (empty($browseNodeIds)) {
            throw new Exception('Browse node IDs array is empty');
        }

        $questionMarks = array_fill(0, count($browseNodeIds), '?');
        $questionMarks = implode(', ', $questionMarks);

        $sql = "
            SELECT `product`.`product_id`

              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `similar_retrieved` IS NULL
               AND `browse_node_id` IN ($questionMarks)

             LIMIT 1
                 ;
        ";
        $parameters = $browseNodeIds;
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['product_id'];
    }

    public function selectProductIdWhereVideoGeneratedIsNullAndBrowseNodeIdInLimit1(
        array $browseNodeIds
    ): int {
        if (empty($browseNodeIds)) {
            throw new Exception('Browse node IDs array is empty');
        }

        $questionMarks = array_fill(0, count($browseNodeIds), '?');
        $questionMarks = implode(', ', $questionMarks);

        $sql = "
            SELECT `product`.`product_id`

              FROM `product`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `video_generated` IS NULL
               AND `browse_node_id` IN ($questionMarks)

             LIMIT 1
                 ;
        ";
        $parameters = $browseNodeIds;
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

    public function selectWhereProductId(int $productId): Generator
    {
        $sql = '
            SELECT `browse_node_id`
                 , `product_id`
              FROM `browse_node_product`
             WHERE `product_id` = ?
             ORDER
                BY `browse_node_id` ASC
                 ;
        ';
        $parameters = [
            $productId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectProductIdHavingMaxOrderIsNullLimit1(): int
    {
        $sql = '
            SELECT `product_id`
                 , MAX(`order`) AS `max_order`
              FROM `browse_node_product`
             GROUP
                BY `product_id`
             HAVING `max_order` IS NULL
             LIMIT 1
                 ;
        ';
        $array = $this->adapter->query($sql)->execute()->current();
        return (int) $array['product_id'];
    }

    protected function getSelect(): string
    {
        return '
            SELECT `browse_node_id`
                 , `product_id`
                 , `order`
        ';
    }
}
