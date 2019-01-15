<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;

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
}
