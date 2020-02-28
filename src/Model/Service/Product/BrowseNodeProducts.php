<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class BrowseNodeProducts
{
    public function __construct(
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->browseNodeFactory      = $browseNodeFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
    }

    public function getBrowseNodeProducts(
        AmazonEntity\Product $productEntity
    ): array {
        try {
            return $productEntity->getBrowseNodeProducts();
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $browseNodeProducts = [];
        $generator = $this->browseNodeProductTable->selectWhereProductId(
            $productEntity->getProductId()
        );
        foreach ($generator as $array) {
            // @todo Move all this stuff to a BrowseNodeProduct factory.
            $browseNodeEntity = $this->browseNodeFactory->buildFromBrowseNodeId(
                $array['browse_node_id']
            );

            $browseNodeProductEntity = new AmazonEntity\BrowseNodeProduct();
            $browseNodeProductEntity->setBrowseNode(
                $browseNodeEntity
            );
            $browseNodeProductEntity->setOrder(
                (int) $array['order']
            );
            if (isset($array['sales_rank'])) {
                $browseNodeProductEntity->setSalesRank(
                    (int) $array['sales_rank']
                );
            }

            $browseNodeProducts[] = $browseNodeProductEntity;
        }
        $productEntity->setBrowseNodeProducts($browseNodeProducts);

        return $browseNodeProducts;
    }
}
