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
     * @var AmazonProductGroupEntity Product group.
     */
    public $productGroup;

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

    public function getPrimaryImage() : ImageEntity\Image
    {
        return $this->primaryImage;
    }

    public function getTitle() : string
    {
        return $this->title;
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
}
