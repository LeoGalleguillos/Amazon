<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class BrowseNodesAndSalesRanks
{
    public function __construct(
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeFactory      = $browseNodeFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getBrowseNodesAndSalesRanks(
        AmazonEntity\Product $productEntity
    ): array {
        try {
            return $productEntity->getBrowseNodesAndSalesRanks();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $browseNodesAndSalesRanks = [];
        $generator = $this->browseNodeProductTable->selectWhereProductId(
            $productEntity->getProductId()
        );
        foreach ($generator as $array) {
            $browseNodeEntity = $this->browseNodeFactory->buildFromBrowseNodeId(
                $array['browse_node_id']
            );
            $browseNodeAndSalesRank = [
                'browse_node' => $browseNodeEntity
            ];

            if (isset($array['sales_rank'])) {
                $browseNodeAndSalesRank['sales_rank'] = (int) $array['sales_rank'];
            }

            $browseNodesAndSalesRanks[] = $browseNodeAndSalesRank;
        }
        $productEntity->setBrowseNodesAndSalesRanks($browseNodesAndSalesRanks);

        return $browseNodesAndSalesRanks;
    }
}
