<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Xml\BrowseNode;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use SimpleXMLElement;

class DownloadToMySql
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeTable        = $browseNodeTable;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function downloadToMySql(
        int $productId,
        SimpleXMLElement $browseNodeXml
    ) {
        $browseNodeId = (int) $browseNodeXml->{'BrowseNodeId'};
        $name         = (string) $browseNodeXml->{'Name'};
        $this->browseNodeTable->insertIgnore(
            $browseNodeId,
            $name
        );
        $this->browseNodeProductTable->insertIgnore(
            $browseNodeId,
            $productId
        );
    }
}
