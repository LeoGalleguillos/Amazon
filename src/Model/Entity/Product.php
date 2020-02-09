<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use DateTime;
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
    public $binding;

    /**
     * @var AmazonEntity\Binding
     */
    public $bindingEntity;

    /**
     * @var AmazonEntity\Brand
     */
    public $brand;

    /**
     * @var AmazonEntity\Brand
     */
    public $brandEntity;

    /**
     * @var array
     */
    protected $browseNodes;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var array Array of editorial reviews.
     */
    public $editorialReviews = [];

    /**
     * @var array Array of product features.
     */
    public $features = [];

    /**
     * @var ImageEntity\Image[]
     */
    protected $hiResImages;

    /**
     * @var string
     */
    protected $heightUnits;

    /**
     * @var float
     */
    protected $heightValue;

    /**
     * @var DateTime
     */
    protected $hiResImagesRetrieved;

    /**
     * @var bool
     */
    protected $isAdultProduct;

    /**
     * @var string
     */
    protected $lengthUnits;

    /**
     * @var float
     */
    protected $lengthValue;

    /**
     * @var float
     */
    public $listPrice;

    /**
     * @var AmazonEntity\ProductGroup
     */
    public $productGroup;

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
     * @var DateTime
     */
    protected $released;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var ImageEntity\Image[]
     */
    public $variantImages;

    /**
     * var DateTime
     */
    protected $videoGenerated;

    /**
     * @var string
     */
    protected $weightUnits;

    /**
     * @var float
     */
    protected $weightValue;

    /**
     * @var string
     */
    protected $widthUnits;

    /**
     * @var float
     */
    protected $widthValue;

    public function getAsin(): string
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

    public function getBrowseNodes(): array
    {
        return $this->browseNodes;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getFeatures() : array
    {
        return $this->features;
    }

    public function getHeightUnits(): string
    {
        return $this->heightUnits;
    }

    public function getHeightValue(): float
    {
        return $this->heightValue;
    }

    public function getHiResImages(): array
    {
        return $this->hiResImages;
    }

    public function getHiResImagesRetrieved(): DateTime
    {
        return $this->hiResImagesRetrieved;
    }

    public function getIsAdultProduct(): bool
    {
        return $this->isAdultProduct;
    }

    public function getLengthUnits(): string
    {
        return $this->lengthUnits;
    }

    public function getLengthValue(): float
    {
        return $this->lengthValue;
    }

    public function getListPrice(): float
    {
        return $this->listPrice;
    }

    public function getProductGroup(): AmazonEntity\ProductGroup
    {
        return $this->productGroup;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getPrimaryImage(): ImageEntity\Image
    {
        return $this->primaryImage;
    }

    public function getReleased(): DateTime
    {
        return $this->released;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getVariantImages(): array
    {
        return $this->variantImages;
    }

    public function getVideoGenerated(): DateTime
    {
        return $this->videoGenerated;
    }

    public function getWeightUnits(): string
    {
        return $this->weightUnits;
    }

    public function getWeightValue(): float
    {
        return $this->weightValue;
    }

    public function getWidthUnits(): string
    {
        return $this->widthUnits;
    }

    public function getWidthValue(): float
    {
        return $this->widthValue;
    }

    public function setAsin(string $asin): AmazonEntity\Product
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

    public function setBrowseNodes(array $browseNodes): AmazonEntity\Product
    {
        $this->browseNodes = $browseNodes;
        return $this;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function setFeatures(array $features) : AmazonEntity\Product
    {
        $this->features = $features;
        return $this;
    }

    public function setHeightUnits(string $heightUnits): self
    {
        $this->heightUnits = $heightUnits;
        return $this;
    }

    public function setHeightValue(float $heightValue): self
    {
        $this->heightValue = $heightValue;
        return $this;
    }

    public function setHiResImages(array $hiResImages): AmazonEntity\Product
    {
        $this->hiResImages = $hiResImages;
        return $this;
    }

    public function setHiResImagesRetrieved(DateTime $hiResImagesRetrieved): AmazonEntity\Product
    {
        $this->hiResImagesRetrieved = $hiResImagesRetrieved;
        return $this;
    }

    public function setIsAdultProduct(bool $isAdultProduct): self
    {
        $this->isAdultProduct = $isAdultProduct;
        return $this;
    }

    public function setLengthUnits(string $lengthUnits): self
    {
        $this->lengthUnits = $lengthUnits;
        return $this;
    }

    public function setLengthValue(float $lengthValue): self
    {
        $this->lengthValue = $lengthValue;
        return $this;
    }

    public function setListPrice(float $listPrice): AmazonEntity\Product
    {
        $this->listPrice = $listPrice;
        return $this;
    }

    public function setPrimaryImage(
        ImageEntity\Image $primaryImage
    ): AmazonEntity\Product {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    public function setProductId(int $productId): AmazonEntity\Product
    {
        $this->productId = $productId;
        return $this;
    }

    public function setProductGroup(
        AmazonEntity\ProductGroup $productGroup
    ): AmazonEntity\Product {
        $this->productGroup = $productGroup;
        return $this;
    }

    public function setReleased(DateTime $released): self
    {
        $this->released = $released;
        return $this;
    }

    public function setTitle(string $title) : AmazonEntity\Product
    {
        $this->title = $title;
        return $this;
    }

    public function setVariantImages(array $variantImages): AmazonEntity\Product
    {
        $this->variantImages = $variantImages;
        return $this;
    }

    public function setVideoGenerated(DateTime $videoGenerated): AmazonEntity\Product
    {
        $this->videoGenerated = $videoGenerated;
        return $this;
    }

    public function setWeightUnits(string $weightUnits): self
    {
        $this->weightUnits = $weightUnits;
        return $this;
    }

    public function setWeightValue(float $weightValue): self
    {
        $this->weightValue = $weightValue;
        return $this;
    }

    public function setWidthUnits(string $widthUnits): self
    {
        $this->widthUnits = $widthUnits;
        return $this;
    }

    public function setWidthValue(float $widthValue): self
    {
        $this->widthValue = $widthValue;
        return $this;
    }
}
