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

    protected function getSelect(): string
    {
        return '
            SELECT `product_video_id`
                 , `product_id`
                 , `title`
                 , `duration_milliseconds`
                 , `created`
        ';
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
             LIMIT 100

        ';
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }

    public function selectAsinWhereMatchAgainst(string $query): Generator
    {
        $sql = '
            SELECT `product`.`asin`
                 , MATCH(`product_video`.`title`) AGAINST (?) AS `score`
              FROM `product`
              JOIN `product_video`
             USING (`product_id`)
             WHERE MATCH(`product_video`.`title`) AGAINST (?)
             ORDER
                BY `score` DESC
             LIMIT 10

        ';
        $parameters = [
            $query,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['asin'];
        }
    }

    public function selectWhereProductId(int $productId): array
    {
        $sql = $this->getSelect()
             . '
              FROM `product_video`
             WHERE `product_id` = ?
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
