<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Xml\BrowseNode;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use SimpleXMLElement;

class DownloadToMySql
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable
    ) {
        $this->browseNodeTable = $browseNodeTable;
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
                $this->downloadToMySql(
                    $child
                );
            }
        }
    }
}
