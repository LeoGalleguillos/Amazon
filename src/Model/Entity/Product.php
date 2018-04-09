<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

use AmazonEntity\Binding as AmazonBindingEntity;
use AmazonEntity\Brand as AmazonBrandEntity;
use AmazonEntity\ProductGroup as AmazonProductGroupEntity;
use ImageEntity\Image as ImageEntity;

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
     * @var ImageEntity
     */
    public $primaryImage;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var ImageEntity[]
     */
    public $variantImages = [];

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title) : AmazonEntity\Product
    {
        $this->title = $title;
        return $this;
    }
}
