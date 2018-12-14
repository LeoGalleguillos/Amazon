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

    public function getProduct(): AmazonEntity\Product
    {
        return $this->product;
    }

    public function setProduct(AmazonEntity\Product $product): AmazonEntity\ProductVideo
    {
        $this->product = $product;
        return $this;
    }
}
