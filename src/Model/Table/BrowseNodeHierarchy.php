<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use Laminas\Db\Adapter\Adapter;

class BrowseNodeHierarchy
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
        int $browseNodeIdParent,
        int $browseNodeIdChild
    ): int {
        $sql = '
            INSERT IGNORE
              INTO `browse_node_hierarchy` (
                       `browse_node_id_parent`
                     , `browse_node_id_child`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $browseNodeIdParent,
            $browseNodeIdChild,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }

    public function selectWhereBrowseNodeIdChild(
        int $browseNodeIdChild
    ): Generator {
        $sql = '
            SELECT `browse_node_id_parent`
                 , `browse_node_id_child`
              FROM `browse_node_hierarchy`
             WHERE `browse_node_id_child` = ?
             ORDER
                BY `browse_node_id_parent` ASC
                 ;
        ';
        $parameters = [
            $browseNodeIdChild,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }

    public function selectWhereBrowseNodeIdParent(
        int $browseNodeIdParent
    ): Generator {
        $sql = '
            SELECT `browse_node_id_parent`
                 , `browse_node_id_child`
              FROM `browse_node_hierarchy`
             WHERE `browse_node_id_parent` = ?
             ORDER
                BY `browse_node_id_child` ASC
                 ;
        ';
        $parameters = [
            $browseNodeIdParent,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
