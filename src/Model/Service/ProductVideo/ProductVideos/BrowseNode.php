<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class BrowseNode
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoTable   = $productVideoTable;
    }

    /**
     * @todo Get arrays for all product_video_id ints in one query rather than
     *       looping through each one. Currently, this method runs a query for
     *       every product_video_id
     */
    public function getProductVideos(
        AmazonEntity\BrowseNode $browseNodeEntity,
        int $page
    ): Generator {
        $result = $this->productVideoTable->selectProductVideoIdWhereBrowseNodeId(
            $browseNodeEntity->getBrowseNodeId(),
            ($page - 1) * 100,
            100
        );

        /*
         * @todo Update this code to get all arrays in one query,
         *       and then build each product video from the array
         *       (rather than run a query for every array each of which contains
         *       only a product_video_id)
         */
        foreach ($result as $array) {
            yield $this->productVideoFactory->buildFromProductVideoId(
                $array['product_video_id']
            );
        }
    }
}
