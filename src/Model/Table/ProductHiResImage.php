<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Zend\Db\Adapter\Adapter;

class ProductHiResImage
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function insert(
        int $productId,
        string $url,
        int $order
    ): int {
        $sql = '
            INSERT
              INTO `product_hi_res_image` (
                         `product_id`
                       , `url`
                       , `order`
                   )
            VALUES (?, ?, ?)
                 ;
        ';

        $parameters = [
            $productId,
            $url,
            $order,
        ];

        return $this->adapter->query($sql)->execute($parameters)->getGeneratedValue();
    }

    public function selectWhereProductId(
        int $productId
    ): Generator {
        $sql = '
            SELECT `product_id`
                 , `url`
                 , `order`
              FROM `product_hi_res_image`
             WHERE `product_id` = ?
             ORDER
                BY `order` ASC
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute([$productId]) as $array) {
            yield $array;
        }
    }
}
