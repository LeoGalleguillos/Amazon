<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Exception;
use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

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

    public function getSelect(): string
    {
        return '
            SELECT `browse_node_id`
                 , `product_id`
                 , `sales_rank`
                 , `order`
        ';
    }

    public function insertOnDuplicateKeyUpdate(
        int $browseNodeId,
        int $productId,
        int $salesRank = null,
        int $order
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `browse_node_product` (
                       `browse_node_id`
                     , `product_id`
                     , `sales_rank`
                     , `order`
                   )
            VALUES (?, ?, ?, ?)
                ON DUPLICATE KEY
            UPDATE `sales_rank` = ?
                 , `order` = ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
            $productId,
            $salesRank,
            $order,
            $salesRank,
            $order,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function selectCountWhereBrowseNodeId(
        int $browseNodeId
    ): Result {
        $sql = '
            SELECT COUNT(*)
              FROM `browse_node_product`
             WHERE `browse_node_id` = ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
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

        if (empty($array)) {
            return 0;
        }

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

        if (empty($array)) {
            return 0;
        }

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

        if (empty($array)) {
            return 0;
        }

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

        if (empty($array)) {
            return 0;
        }

        return (int) $array['product_id'];
    }

    public function selectWhereProductId(int $productId): Generator
    {
        $sql = $this->getSelect()
             . '
              FROM `browse_node_product`
             WHERE `product_id` = ?
             ORDER
                BY `order` ASC
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

    public function selectProductIdWhereBrowseNodeIdLimit(
        int $browseNodeId,
        int $limitOffset,
        int $limitRowCount
    ): Result {
        $sql = '
            SELECT `product_id`
              FROM `browse_node_product`
             WHERE `browse_node_id` = ?
             ORDER
                BY `product_id` DESC
             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
            $limitOffset,
            $limitRowCount
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
