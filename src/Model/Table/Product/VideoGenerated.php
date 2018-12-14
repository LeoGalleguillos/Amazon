<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

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
}
