<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use TypeError;
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
                 , `product_video`.`modified`
        ';
    }

    public function insertOnDuplicateKeyUpdate(
        int $productId,
        string $title,
        int $durationMilliseconds
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

                ON DUPLICATE KEY UPDATE
                   `title` = ?
                 , `duration_milliseconds` = ?
                 , `modified` = UTC_TIMESTAMP()

                 ;
        ';
        $parameters = [
            $productId,
            $title,
            $durationMilliseconds,
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
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              LEFT
              JOIN `browse_node_product`
                ON `browse_node_product`.`product_id` = `product`.`product_id`
               AND `browse_node_product`.`order` = 1

              LEFT
              JOIN `browse_node`
             USING (`browse_node_id`)

             ORDER
                BY `product_video`.`created` ASC
             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
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

    public function selectCount(): int
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product_video`
                 ;
        ';
        return (int) $this->adapter->query($sql)->execute()->current()['count'];
    }

    public function selectCountWhereBrowseNodeId(
        int $browseNodeId
    ): int {
        $sql = '
            SELECT COUNT(*) AS `count`

              FROM `product_video`

              JOIN `browse_node_product`
             USING (`product_id`)

             WHERE `browse_node_product`.`browse_node_id` = ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }

    public function selectOrderByCreatedDesc(): Generator
    {
        $sql = $this->getSelect()
            . '
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              LEFT
              JOIN `browse_node_product`
                ON `browse_node_product`.`product_id` = `product`.`product_id`
               AND `browse_node_product`.`order` = 1

              LEFT
              JOIN `browse_node`
             USING (`browse_node_id`)

             ORDER
                BY `product_video`.`created` DESC

             LIMIT 100

        ';
        foreach ($this->adapter->query($sql)->execute() as $array) {
            yield $array;
        }
    }

    /**
     * @throws TypeError
     */
    public function selectProductIdWhereModifiedIsNullLimit1(): int
    {
        $sql = '
            SELECT `product_id`
              FROM `product_video`
             WHERE `modified` IS NULL
             LIMIT 1
                 ;
        ';
        $array = $this->adapter->query($sql)->execute()->current();

        if (empty($array)) {
            throw new TypeError('Product ID not found.');
        }

        return (int) $array['product_id'];
    }

    /**
     * @throws TypeError
     */
    public function selectWhereAsin(string $asin): array
    {
        $sql = $this->getSelect()
             . '
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              LEFT
              JOIN `browse_node_product`
                ON `browse_node_product`.`product_id` = `product`.`product_id`
               AND `browse_node_product`.`order` = 1

              LEFT
              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `product`.`asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function selectWhereBrowseNodeId(
        int $browseNodeId,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->getSelect()
             . "
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              JOIN `browse_node_product`
             USING (`product_id`)

              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `browse_node_product`.`browse_node_id` = ?

             ORDER
                BY `product_video`.`created` DESC

             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        $parameters = [
            $browseNodeId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectWhereBrowseNodeName(
        string $name,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $sql = $this->getSelect()
             . "
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              JOIN `browse_node_product`
             USING (`product_id`)

              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `browse_node`.`name` = ?

             ORDER
                BY `product_video`.`created` DESC

             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        $parameters = [
            $name,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectWhereBrowseNodeNameNotIn(
        array $browseNodeNames,
        int $limitOffset,
        int $limitRowCount
    ): Generator {
        $questionMarks = array_fill(0, count($browseNodeNames), '?');
        $questionMarks = implode(', ', $questionMarks);

        $sql = $this->getSelect()
             . "
                 , `product`.`product_id`
                 , `product`.`asin`
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              JOIN `browse_node_product`
             USING (`product_id`)

              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `browse_node`.`name` NOT IN ($questionMarks)

             ORDER
                BY `product_video`.`created` DESC

             LIMIT $limitOffset, $limitRowCount
                 ;
        ";
        $parameters = $browseNodeNames;
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
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
                 , `browse_node`.`name` AS `browse_node.name`

              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

              LEFT
              JOIN `browse_node_product`
                ON `browse_node_product`.`product_id` = `product`.`product_id`
               AND `browse_node_product`.`order` = 1

              LEFT
              JOIN `browse_node`
             USING (`browse_node_id`)

             WHERE `product_video_id` = ?
                 ;
        ';
        $parameters = [
            $productVideoId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }
}
