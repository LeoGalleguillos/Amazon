<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Newest\BrowseNode;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Name
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\IsValidCreatedProductId $isValidCreatedProductIdTable
    ) {
        $this->productFactory               = $productFactory;
        $this->isValidCreatedProductIdTable = $isValidCreatedProductIdTable;
    }

    public function getNewestProducts($browseNodeName): Generator
    {
        $result = $this->isValidCreatedProductIdTable
            ->selectProductIdWhereBrowseNodeName($browseNodeName);

        foreach ($result as $array) {
            yield $this->productFactory->buildFromProductId(
                $array['product_id']
            );
        }
    }
}
