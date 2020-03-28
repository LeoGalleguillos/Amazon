<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Newest;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class BrowseNode
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->productFactory         = $productFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getNewestProducts(
        AmazonEntity\BrowseNode $browseNodeEntity,
        int $page
    ): Generator {
        $result = $this->browseNodeProductTable
            ->selectProductIdWhereBrowseNodeIdLimit(
                $browseNodeEntity->getBrowseNodeId(),
                ($page - 1) * 100,
                100
            );
        foreach ($result as $array) {
            yield $this->productFactory->buildFromProductId(
                (int) $array['product_id']
            );
        }
    }
}
