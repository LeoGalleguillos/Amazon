<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\BrowseNodes\BrowseNode;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable,
        AmazonTable\BrowseNodeHierarchy $browseNodeHierarchyTable
    ) {
        $this->browseNodeTable          = $browseNodeTable;
        $this->browseNodeHierarchyTable = $browseNodeHierarchyTable;
    }

    public function saveArrayToMySql(
        array $browseNodeArray
    ) {
        $browseNodeId = (int) $browseNodeArray['Id'];
        $name         = (string) $browseNodeArray['DisplayName'];
        $this->browseNodeTable->insertIgnore(
            $browseNodeId,
            $name
        );

        if (isset($browseNodeArray['Ancestor'])) {
            $parentArray        = $browseNodeArray['Ancestor'];
            $parentBrowseNodeId = (int) $parentArray['Id'];
            $this->browseNodeHierarchyTable->insertIgnore(
                $parentBrowseNodeId,
                $browseNodeId
            );
            $this->saveArrayToMySql(
                $parentArray
            );
        }
    }
}
