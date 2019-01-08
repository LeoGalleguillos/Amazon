<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use TypeError;
use Zend\Db\Adapter\Adapter;

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
