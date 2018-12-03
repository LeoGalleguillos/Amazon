<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

class HiResImagesRetrieved
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

    public function selectWhereProductId(int $productId): string
    {
        $sql = '
            SELECT `product`.`hi_res_images_retrieved`
              FROM `product`
             WHERE `product`.`product_id` = ?
                 ;
        ';
        $array = $this->adapter->query($sql)->execute([$productId])->current();
        return $array['hi_res_images_retrieved'];
    }

    public function updateSetToUtcTimestampWhereProductId($productId): int
    {
        $sql = '
            UPDATE `product`
               SET `product`.`hi_res_images_retrieved` = UTC_TIMESTAMP()
             WHERE `product`.`product_id` = ?
                 ;
        ';
        return $this->adapter->query($sql)->execute([$productId])->getRowsAffected();
    }
}
