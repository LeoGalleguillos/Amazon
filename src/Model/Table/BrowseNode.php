<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
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
}
