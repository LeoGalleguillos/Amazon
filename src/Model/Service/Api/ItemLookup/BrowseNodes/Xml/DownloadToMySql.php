<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ItemLookup\BrowseNodes\Xml;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use SimpleXMLElement;

class DownloadToMySql
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->browseNodeTable        = $browseNodeTable;
        $this->browseNodeProductTable = $browseNodeProductTable;
        $this->asinTable              = $asinTable;
    }

    public function downloadToMySql(
        SimpleXMLElement $xml
    ) {
        $itemXml = $xml->{'Items'}->{'Item'};
        $asin    = (string) $itemXml->{'ASIN'};

        $productId = $this->asinTable->selectProductIdWhereAsin($asin);

        foreach ($itemXml->{'BrowseNodes'}->{'BrowseNode'} as $browseNode) {
            $browseNodeId = (int) $browseNode->{'BrowseNodeId'};
            $name         = (string) $browseNode->{'Name'};
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
}
