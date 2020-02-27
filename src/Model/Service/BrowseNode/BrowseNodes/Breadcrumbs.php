<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use TypeError;

class Breadcrumbs
{
    /**
     * @return AmazonEntity\BrowseNode[]
     */
    public function getBrowseNodes(AmazonEntity\BrowseNode $browseNodeEntity): array
    {
        $browseNodes = [];

        try {
            $parent = $browseNodeEntity->getParents()[0];
            if (!empty($parent->getName())) {
                $browseNodes += $this->getBrowseNodes($parent);
            }
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $browseNodes[] = $browseNodeEntity;

        return $browseNodes;
    }
}
