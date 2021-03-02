<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;

class ProductGroupVideoGeneratedCreated
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

    public function selectAsinWhereProductGroupDoesNotEqualBookAndVideoGeneratedIsNullOrderByCreatedDescLimit1(): string
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`product_group` != \'Book\'
               AND `product`.`video_generated` IS NULL
             ORDER
                BY `product`.`created` DESC
             LIMIT 1
                 ;
        ';
        $array = $this->adapter->query($sql)->execute()->current();
        return $array['asin'];
    }
}
