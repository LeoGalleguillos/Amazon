<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

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

    public function selectWhereProductIdIn(array $productIds): Result
    {
        $questionMarks = array_fill(0, count($productIds), '?');
        $questionMarks = implode(', ', $questionMarks);

        $sql = $this->productTable->getSelect()
            . "
              FROM `product`
             WHERE `product_id` IN ($questionMarks)
        ";
        $parameters = $productIds;

        return $this->adapter->query($sql)->execute($parameters);
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

    public function updateSetModifiedToUtcTimestampWhereProductId(int $productId): Result
    {
        $sql = '
            UPDATE `product`
               SET `modified` = UTC_TIMESTAMP()
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function updateSetSimilarRetrievedToUtcTimestampWhereProductId(int $productId): Result
    {
        $sql = '
            UPDATE `product`
               SET `similar_retrieved` = UTC_TIMESTAMP()
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
