<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

use Zend\Db\Adapter\Adapter;

class ProductVideoId
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
