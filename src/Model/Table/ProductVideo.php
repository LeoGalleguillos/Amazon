<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Zend\Db\Adapter\Adapter;

class ProductVideo
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
        string $title,
        int $durationMilliseconds = null
    ): int {
        $sql = '
            INSERT
              INTO `product_video` (
                       `product_id`
                     , `title`
                     , `duration_milliseconds`
                     , `created`
                   )
            VALUES (?, ?, ?, UTC_TIMESTAMP())
                 ;
        ';
        $parameters = [
            $productId,
            $title,
            $durationMilliseconds,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    public function selectAsinOrderByCreatedDesc(): Generator
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
              JOIN `product_video`
             USING (`product_id`)
             ORDER
                BY `product_video`.`created` DESC
             LIMIT 10

        ';
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }
}
