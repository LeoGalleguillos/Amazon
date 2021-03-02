<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;

class VideoGenerated
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

    public function updateSetToUtcTimestampWhereProductId($productId): int
    {
        $sql = '
            UPDATE `product`
               SET `product`.`video_generated` = UTC_TIMESTAMP()
             WHERE `product`.`product_id` = ?
                 ;
        ';
        return $this->adapter->query($sql)->execute([$productId])->getAffectedRows();
    }

    public function selectAsinWhereVideoGeneratedIsNullOrderByCreatedDescLimit1(): string
    {
        $sql = '
            SELECT `asin`
              FROM `product`
             WHERE `video_generated` IS NULL
             ORDER
                BY `created` DESC
             LIMIT 1
        ';
        $array = $this->adapter->query($sql)->execute()->current();
        return $array['asin'];
    }
}
