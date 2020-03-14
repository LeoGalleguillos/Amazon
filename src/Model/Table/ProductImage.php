<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pdo\Result;

class ProductImage
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

    public function deleteWhereProductId(int $productId): Result
    {
        $sql = '
            DELETE
              FROM `product_image`
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function selectWhereProductId(int $productId): Generator
    {
        $sql = '
            SELECT `product_image`.`product_id`
                 , `product_image`.`category`
                 , `product_image`.`url`
                 , `product_image`.`width`
                 , `product_image`.`height`
              FROM `product_image`
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function insertIgnore(
        int $productId,
        string $category,
        string $url,
        int $width,
        int $height
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `product_image` (
                         `product_id`
                       , `category`
                       , `url`
                       , `width`
                       , `height`
                   )
            VALUES (?, ?, ?, ?, ?)
                 ;
        ';
        $parameters = [
            $productId,
            $category,
            $url,
            $width,
            $height,
        ];
        return $this->adapter->query($sql)->execute($parameters)->getAffectedRows();
    }
}
