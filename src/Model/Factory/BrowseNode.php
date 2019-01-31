<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class BrowseNode
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable,
        AmazonTable\BrowseNodeHierarchy $browseNodeHierarchyTable
    ) {
        $this->browseNodeTable          = $browseNodeTable;
        $this->browseNodeHierarchyTable = $browseNodeHierarchyTable;
    }

    public function buildFromBrowseNodeId(
        int $browseNodeId
    ): AmazonEntity\BrowseNode {
        $browseNodeEntity = new AmazonEntity\BrowseNode();

        $array = $this->browseNodeTable->selectWhereBrowseNodeId(
            $browseNodeId
        );

        $browseNodeEntity->setBrowseNodeId((int) $array['browse_node_id'])
            ->setName($array['name']);

        $generator = $this->browseNodeHierarchyTable->selectWhereBrowseNodeIdChild(
            $browseNodeEntity->getBrowseNodeId()
        );

        $parents = [];
        foreach ($generator as $array) {
            $parents[] = $this->buildFromBrowseNodeId(
                $array['browse_node_id_parent']
            );
        }

        if (!empty($parents)) {
            $browseNodeEntity->setParents($parents);
        }

        return $browseNodeEntity;
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
