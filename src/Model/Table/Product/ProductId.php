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

    public function selectMaxWhereProductGroup(string $productGroup) : int
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

    public function selectWhereGreaterThanOrEqualToAndProductGroup(
        int $productIdLowerLimit,
        string $productGroup
    ) : int {
        $sql = '
            SELECT `product`.`product_id`
              FROM `product`
             WHERE `product`.`product_id` >= :productIdLowerLimit
               AND `product`.`product_group` = :productGroup
             LIMIT 1
                 ;
        ';
        $parameters = [
            'productIdLowerLimit' => $productIdLowerLimit,
            'productGroup'        => $productGroup,
        ];
        $row = $this->adapter->query($sql)->execute($parameters)->current();
        return $row['product_id'];
    }
}
