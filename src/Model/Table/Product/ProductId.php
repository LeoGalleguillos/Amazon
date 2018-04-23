<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

class ProductId
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    public function selectMaxWhereProductGroup(string $productGroup)
    {
        $sql = '
            SELECT MAX(`product`.`product_id`) AS `product_id`
              FROM `product`
             WHERE `product`.`product_group` = ?
                 ;
        ';
        $row = $this->adapter->query($sql)->execute([$productGroup])->current();
        return $row['product_id'];
    }
}
