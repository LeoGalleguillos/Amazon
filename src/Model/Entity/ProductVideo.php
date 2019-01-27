<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Video\Model\Entity as VideoEntity;

class ProductVideo extends VideoEntity\Video
{
    /**
     * @var AmazonEntity\Product
     */
    protected $product;

    /**
     * @var int
     */
    protected $productVideoId;

    public function getProduct(): AmazonEntity\Product
    {
        return $this->product;
    }

    public function getProductVideoId(): int
    {
        return $this->productVideoId;
    }

    public function setProduct(AmazonEntity\Product $product): AmazonEntity\ProductVideo
    {
        $this->product = $product;
        return $this;
    }

    public function setProductVideoId(int $productVideoId): AmazonEntity\ProductVideo
    {
        $this->productVideoId = $productVideoId;
        return $this;
    }
}
