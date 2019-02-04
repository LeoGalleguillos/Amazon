<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class Breadcrumbs
{
    public function getBrowseNodes(AmazonEntity\BrowseNode $browseNodeEntity): Generator
    {
        try {
            $child = $browseNodeEntity->getChildren()[0];
            yield $this->getBrowseNodes($child);
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        yield $browseNodeEntity;
    }
}
