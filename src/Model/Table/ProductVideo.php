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
            SELECT `product_video`.`product_video_id`
                 , `product_video`.`product_id`
                 , `product_video`.`title`
                 , `product_video`.`duration_milliseconds`
                 , `product_video`.`created`
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

    public function select(
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->getSelect()
             . "
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `product`.`title`
                 , `product`.`product_group`
                 , `product`.`binding`
                 , `product`.`brand`
                 , `product`.`list_price`
              FROM `product_video`
              JOIN `product`
             USING (`product_id`)
             ORDER
                BY `product_video`.`created` ASC
             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
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
                 ;
        ';
        $parameters = [
            $query,
            $query,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array['asin'];
        }
    }

    /**
     * @throws TypeError
     */
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
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    /**
     * @throws TypeError
     */
    public function selectWhereProductVideoId(int $productVideoId): array
    {
        $sql = $this->getSelect()
             . '
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `product`.`title`
                 , `product`.`product_group`
                 , `product`.`binding`
                 , `product`.`brand`
                 , `product`.`list_price`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

             WHERE `product_video_id` = ?
                 ;
        ';
        $parameters = [
            $productVideoId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
