<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

use AmazonEntity\Binding as AmazonBindingEntity;
use AmazonEntity\Brand as AmazonBrandEntity;
use AmazonEntity\ProductGroup as AmazonProductGroupEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;

class Product
{
    /**
     * @var AmazonBindingEntity Binding.
     */
    public $asin;

    /**
     * @var AmazonBindingEntity Binding.
     */
    public $binding;

    /**
     * @var AmazonBrandEntity Binding.
     */
    public $brand;

    /**
     * @var array Array of editorial reviews.
     */
    public $editorialReviews = [];

    /**
     * @var array Array of product features.
     */
    public $features = [];

    /**
     * @var AmazonEntity\ProductGroup Product group entity.
     */
    protected $productGroupEntity;

    /**
     * @var int Product ID.
     */
    public $productId;

    /**
     * @var ImageEntity\Image
     */
    public $primaryImage;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var ImageEntity\Image[]
     */
    public $variantImages = [];

    public function getAsin() : string
    {
        return $this->asin;
    }

    public function getProductGroupEntity() : AmazonEntity\ProductGroup
    {
        return $this->productGroupEntity;
    }

    public function getPrimaryImage() : ImageEntity\Image
    {
        return $this->primaryImage;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getVariantImages() : array
    {
        return $this->variantImages;
    }

    public function setAsin(string $asin) : AmazonEntity\Product
    {
        $this->asin = $asin;
        return $this;
    }

    public function setPrimaryImage(
        ImageEntity\Image $primaryImage
    ) : AmazonEntity\Product {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    public function setTitle(string $title) : AmazonEntity\Product
    {
        $this->title = $title;
        return $this;
    }

    public function setVariantImages(array $variantImages) : AmazonEntity\Product
    {
        $this->variantImages = $variantImages;
        return $this;
    }
}
