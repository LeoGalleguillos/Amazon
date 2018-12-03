<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;

class ProductHiResImage
{
    /**
     * @var Adapter
     */
    protected private $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function insertIgnore(
        int $productId,
        string $url,
        int $order
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `product_hi_res_image` (
                         `product_id`
                       , `url`
                       , `order`
                   )
            VALUES ?, ?, ?
                 ;
        ';

        $parameters = [
            $productId,
            $url,
            $order,
        ];

        return $this->adapter->query($sql)->execute($parameters)->getGeneratedValue();
    }
}
