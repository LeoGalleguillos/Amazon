<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;

class Product
{
    /**
     * @var string
     */
    public $asin;

    /**
     * @var AmazonEntity\Binding
     */
    public $bindingEntity;

    /**
     * @var AmazonEntity\Brand
     */
    public $brandEntity;

    /**
     * @var array Array of editorial reviews.
     */
    public $editorialReviews = [];

    /**
     * @var array Array of product features.
     */
    public $features = [];

    /**
     * var ImageEntity\Image[]
     */
    protected $hiResImages;

    /**
     * @var AmazonEntity\ProductGroup
     */
    protected $productGroup;

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

    public function getBindingEntity() : AmazonEntity\Binding
    {
        return $this->bindingEntity;
    }

    public function getBrandEntity() : AmazonEntity\Brand
    {
        return $this->brandEntity;
    }

    public function getFeatures() : array
    {
        return $this->features;
    }

    public function getHiResImages(): array
    {
        return $this->hiResImages;
    }

    public function getProductGroup(): AmazonEntity\ProductGroup
    {
        return $this->productGroup;
    }

    public function getProductGroupEntity() : AmazonEntity\ProductGroup
    {
        return $this->productGroupEntity;
    }

    public function getProductId() : int
    {
        return $this->productId;
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

    public function setBindingEntity(
        AmazonEntity\Binding $bindingEntity
    ) : AmazonEntity\Product {
        $this->bindingEntity = $bindingEntity;
        return $this;
    }

    public function setBrandEntity(
        AmazonEntity\Brand $brandEntity
    ) : AmazonEntity\Product {
        $this->brandEntity = $brandEntity;
        return $this;
    }

    public function setFeatures(array $features) : AmazonEntity\Product
    {
        $this->features = $features;
        return $this;
    }

    public function setHiResImages(array $hiResImages): AmazonEntity\Product
    {
        $this->hiResImages = $hiResImages;
        return $this;
    }

    public function setPrimaryImage(
        ImageEntity\Image $primaryImage
    ) : AmazonEntity\Product {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    public function setProductId(
        int $productId
    ) : AmazonEntity\Product {
        $this->productId = $productId;
        return $this;
    }

    public function setProductGroup(
        AmazonEntity\ProductGroup $productGroup
    ): AmazonEntity\Product {
        $this->productGroup = $productGroup;
        return $this;
    }

    public function setProductGroupEntity(
        AmazonEntity\ProductGroup $productGroupEntity
    ) : AmazonEntity\Product {
        $this->productGroupEntity = $productGroupEntity;
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
