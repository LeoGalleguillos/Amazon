<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class Breadcrumbs
{
    public function getBrowseNodes(AmazonEntity\BrowseNode $browseNodeEntity): array
    {
        $browseNodes = [];

        try {
            $parent = $browseNodeEntity->getParents()[0];
            $browseNodes += $this->getBrowseNodes($parent);
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $browseNodes[] = $browseNodeEntity;

        return $browseNodes;
    }
}
