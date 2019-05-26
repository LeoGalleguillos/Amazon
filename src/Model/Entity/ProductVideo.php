<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Video\Model\Entity as VideoEntity;

class ProductVideo extends VideoEntity\Video
{
    /**
     * @var string
     */
    protected $asin;

    /**
     * @var string
     */
    protected $browseNodeName;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var AmazonEntity\Product
     */
    protected $product;

    /**
     * @var int
     */
    protected $productId;

    /**
     * @var int
     */
    protected $productVideoId;

    public function getAsin(): string
    {
        return $this->asin;
    }

    public function getBrowseNodeName(): string
    {
        return $this->browseNodeName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProduct(): AmazonEntity\Product
    {
        return $this->product;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getProductVideoId(): int
    {
        return $this->productVideoId;
    }

    public function setAsin(string $asin): AmazonEntity\ProductVideo
    {
        $this->asin = $asin;
        return $this;
    }

    public function setBrowseNodeName(string $browseNodeName): AmazonEntity\ProductVideo
    {
        $this->browseNodeName = $browseNodeName;
        return $this;
    }

    public function setDescription(string $description): AmazonEntity\ProductVideo
    {
        $this->description = $description;
        return $this;
    }

    public function setProduct(AmazonEntity\Product $product): AmazonEntity\ProductVideo
    {
        $this->product = $product;
        return $this;
    }

    public function setProductId(int $productId): AmazonEntity\ProductVideo
    {
        $this->productId = $productId;
        return $this;
    }

    public function setProductVideoId(int $productVideoId): AmazonEntity\ProductVideo
    {
        $this->productVideoId = $productVideoId;
        return $this;
    }
}
