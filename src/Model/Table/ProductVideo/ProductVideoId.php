<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

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

    public function selectCountWhereProductVideoIdLessThanOrEqualTo(int $maxProductVideoId): int
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product_video`
             WHERE `product_video_id` <= ?
        ';
        $parameters = [
            $maxProductVideoId,
        ];
        $row = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $row['count'];
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
              FROM `product_video`
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
