<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductVideo
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productFactory    = $productFactory;
        $this->productVideoTable = $productVideoTable;
    }

    public function buildFromArray(array $array): AmazonEntity\ProductVideo
    {
        $productVideoEntity = new AmazonEntity\ProductVideo();
        $productVideoEntity
            ->setAsin($array['asin'])
            ->setCreated(new DateTime($array['created']))
            ->setDurationMilliseconds((int) $array['duration_milliseconds'])
            ->setProductId((int) $array['product_id'])
            ->setProductVideoId((int) $array['product_video_id'])
            ->setTitle($array['title']);

        if (isset($array['browse_node.name'])) {
            $productVideoEntity->setBrowseNodeName($array['browse_node.name']);
        }

        return $productVideoEntity;
    }

    public function buildFromAsin(string $asin): AmazonEntity\ProductVideo
    {
        $productVideoEntity = new AmazonEntity\ProductVideo();

        $productVideoEntity->setProduct(
            $this->productFactory->buildFromAsin($asin)
        );

        $array = $this->productVideoTable->selectWhereProductId(
            $productVideoEntity->getProduct()->getProductId()
        );

        $productVideoEntity->setCreated(new DateTime($array['created']))
                           ->setDurationMilliseconds($array['duration_milliseconds'])
                           ->setProductVideoId($array['product_video_id'])
                           ->setTitle($array['title']);

        return $productVideoEntity;
    }

    public function buildFromProductVideoId(
        int $productVideoId
    ): AmazonEntity\ProductVideo {
        return $this->buildFromArray(
            $this->productVideoTable->selectWhereProductVideoId($productVideoId)
        );
    }
}
