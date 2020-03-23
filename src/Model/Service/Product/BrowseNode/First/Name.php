<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\BrowseNode\First;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class Name
{
    public function __construct(
        AmazonTable\BrowseNode $browseNodeTable
    ) {
        $this->browseNodeTable = $browseNodeTable;
    }

    /**
     * @throws Exception
     */
    public function getFirstBrowseNodeName(
        AmazonEntity\Product $productEntity
    ):string {
        try {
            $browseNodeProducts = $productEntity->getBrowseNodeProducts();
            if (!empty($browseNodeProducts)) {
                return $browseNodeProducts[0]->getBrowseNode()->getName();
            }
        } catch (TypeError $typeError) {
            // Get first browse node name in code below.
        }

        $result = $this->browseNodeTable->selectNameWhereProductIdLimit1(
            $productEntity->getProductId()
        );
        $currentArray = $result->current();
        if (!empty($currentArray['name'])) {
            return $currentArray['name'];
        }

        throw new Exception('No browse nodes found.');
    }
}
