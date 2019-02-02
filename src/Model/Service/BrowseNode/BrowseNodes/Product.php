<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Product
{
    public function __construct(
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeFactory      = $browseNodeFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getBrowseNodes(AmazonEntity\Product $productEntity): Generator
    {
        $generator = $this->browseNodeProductTable->selectWhereProductId(
            $productEntity->getProductId()
        );
        foreach ($generator as $array) {
            yield $this->browseNodeFactory->buildFromBrowseNodeId(
                $array['browse_node_id']
            );
        }
    }
}
