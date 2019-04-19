<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Exception;
use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use Zend\Db\Adapter\Adapter;

class ProductId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\Product $productTable
    ) {
        $this->adapter      = $adapter;
        $this->productTable = $productTable;
    }

    public function selectAsinWhereProductIdIn(array $productIds): Generator
    {
        $questionMarks = array_fill(0, count($productIds), '?');
        $questionMarks = implode(', ', $questionMarks);

        $sql = "
            SELECT `asin`
              FROM `product`
             WHERE `product_id` IN ($questionMarks)
        ";
        $parameters = $productIds;

        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['asin'];
        }
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

    /**
     * @throws TypeError
     */
    public function selectWhereProductId(int $productId): array
    {
        $sql = $this->productTable->getSelect()
             . '
              FROM `product`
             WHERE `product`.`product_id` = ?
                 ;
        ';
        return $this->adapter->query($sql)->execute([$productId])->current();
    }
}
