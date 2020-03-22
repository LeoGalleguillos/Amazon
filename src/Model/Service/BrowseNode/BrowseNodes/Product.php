<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

/**
 * @deprecated Use AmazonService\Product\BrowseNodeProducts::getBrowseNodeProducts() instead
 */
class Product
{
    public function __construct(
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeFactory      = $browseNodeFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getBrowseNodes(AmazonEntity\Product $productEntity): array
    {
        try {
            return $productEntity->getBrowseNodes();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $browseNodeEntities = [];
        $generator = $this->browseNodeProductTable->selectWhereProductId(
            $productEntity->getProductId()
        );
        foreach ($generator as $array) {
            $browseNodeEntities[] = $this->browseNodeFactory->buildFromBrowseNodeId(
                $array['browse_node_id']
            );
        }
        $productEntity->setBrowseNodes($browseNodeEntities);

        return $browseNodeEntities;
    }
}
