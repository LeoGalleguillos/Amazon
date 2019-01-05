<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class BrowseNode
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable
    ) {
        $this->browseNodeTable = $browseNodeTable;
    }

    public function buildFromArray(
        array $array
    ): AmazonEntity\BrowseNode {
        $browseNodeEntity = new AmazonEntity\BrowseNode();

        $browseNodeEntity->setBrowseNodeId($array['browse_node_id'])
                         ->setName($array['name']);

        return $browseNodeEntity;
    }
}
