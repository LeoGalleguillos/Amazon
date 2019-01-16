<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Xml\BrowseNode;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use SimpleXMLElement;

class DownloadToMySql
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable,
        AmazonTable\BrowseNodeHierarchy $browseNodeHierarchyTable
    ) {
        $this->browseNodeTable          = $browseNodeTable;
        $this->browseNodeHierarchyTable = $browseNodeHierarchyTable;
    }

    public function downloadToMySql(
        SimpleXMLElement $browseNodeXml
    ) {
        $browseNodeId = (int) $browseNodeXml->{'BrowseNodeId'};
        $name         = (string) $browseNodeXml->{'Name'};
        $this->browseNodeTable->insertIgnore(
            $browseNodeId,
            $name
        );

        if (isset($browseNodeXml->{'Children'}->{'BrowseNode'})) {
            foreach ($browseNodeXml->{'Children'}->{'BrowseNode'} as $child) {
                $childBrowseNodeId = (int) $child->{'BrowseNodeId'};
                $this->browseNodeHierarchyTable->insertIgnore(
                    $browseNodeId,
                    $childBrowseNodeId
                );
                $this->downloadToMySql(
                    $child
                );
            }
        }

        if (isset($browseNodeXml->{'Ancestors'}->{'BrowseNode'})) {
            $parent = $browseNodeXml->{'Ancestors'}->{'BrowseNode'};
            $parentBrowseNodeId = (int) $parent->{'BrowseNodeId'};
            $this->browseNodeHierarchyTable->insertIgnore(
                $parentBrowseNodeId,
                $browseNodeId
            );
            $this->downloadToMySql(
                $parent
            );
        }
    }
}
