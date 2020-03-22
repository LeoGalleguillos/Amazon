<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class BrowseNode
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

    public function insertIgnore(
        int $browseNodeId,
        string $name
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `browse_node` (
                       `browse_node_id`
                     , `name`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $browseNodeId,
            $name,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function selectNameWhereProductIdLimit1(
        int $productId
    ): Result {
        $sql = '
            SELECT `browse_node`.`name`

              FROM `browse_node`

              JOIN `browse_node_product`
             USING (`browse_node_id`)

             WHERE `browse_node_product`.`product_id` = ?

             ORDER
                BY `browse_node_product`.`order` ASC

             LIMIT 1
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }


    public function selectWhereBrowseNodeId(int $browseNodeId): array
    {
        $sql = '
            SELECT `browse_node_id`
                 , `name`
              FROM `browse_node`
             WHERE `browse_node_id` = ?
                 ;
        ';
        $parameters = [
            $browseNodeId,
        ];
        return $this->adapter->query($sql)->execute($parameters)->current();
    }

    public function selectWhereName(string $name): Generator
    {
        $sql = '
            SELECT `browse_node_id`
                 , `name`
              FROM `browse_node`
             WHERE `name` = ?
             ORDER
                BY `browse_node_id` ASC
                 ;
        ';
        $parameters = [
            $name,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
