<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

use Exception;
use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use Zend\Db\Adapter\Adapter;

class ProductVideoId
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

    public function selectProductVideoIdLimitOffsetLimit1(int $limitOffset): int
    {
        $sql = '
            SELECT `product_video_id`
              FROM `product_video`
             ORDER
                BY `product_video_id` ASC
             LIMIT ?, 1
        ';
        $parameters = [
            $limitOffset,
        ];
        $row = $this->adapter->query($sql)->execute($parameters)->current();

        if ($row === false) {
            throw new Exception('No rows found.');
        }

        return (int) $row['product_video_id'];
    }

    /**
     * @yield array
     */
    public function selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
        int $minProductVideoId,
        int $limitRowCount
    ): Generator {
        $sql = $this->productVideoTable->getSelect()
            . '
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              LEFT
              JOIN `browse_node_product`
                ON `browse_node_product`.`product_id` = `product_video`.`product_id`
               AND `browse_node_product`.`order` = 1

              LEFT
              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `product_video_id` >= ?
             ORDER
                BY `product_video_id` ASC
             LIMIT ?
        ';
        $parameters = [
            $minProductVideoId,
            $limitRowCount,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    /**
     * @deprecated Instead, use the following method:
     * AmazonTable\ProductVideo\ProductId::updateSetModifiedToUtcTimestampWhereProductId
     */
    public function updateSetModifiedToUtcTimestampWhereProductId(
        int $productId
    ): int {
        $sql = '
            UPDATE `product_video`
               SET `modified` = UTC_TIMESTAMP()
             WHERE `product_id` = ?
        ';
        $parameters = [
            $productId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetModifiedToUtcTimestampWhereProductVideoId(
        int $productVideoId
    ): int {
        $sql = '
            UPDATE `product_video`
               SET `modified` = UTC_TIMESTAMP()
             WHERE `product_video_id` = ?
        ';
        $parameters = [
            $productVideoId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }

    public function updateSetViewsToViewsPlusOneWhereProductVideoId(
        int $productVideoId
    ): int {
        $sql = '
            UPDATE `product_video`
               SET `views` = `views` + 1
             WHERE `product_video_id` = ?
        ';
        $parameters = [
            $productVideoId,
        ];
        return (int) $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
