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
     * @var string
     */
    protected $brand;

    /**
     * @var array
     */
    protected $browseNodeProducts;

    /**
     * @var array
     * @deprecated Use ::browseNodeProducts instead
     */
    protected $browseNodes;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var DateTime
     */
    protected $created;

    /**
     * @var array
     */
    protected $eans;

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
     * @var array
     */
    protected $isbns;

    /**
     * @var bool
     */
    protected $isEligibleForTradeIn;

    /**
     * @var bool
     */
    protected $isValid;

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
     * @var string
     */
    protected $manufacturer;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var DateTime
     */
    protected $modified;

    /**
     * @var array
     */
    protected $offers;

    /**
     * @var string
     */
    protected $partNumber;

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
    protected $size;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var float
     */
    protected $tradeInPrice;

    /**
     * @var int
     */
    public $unitCount;

    /**
     * @var array
     */
    protected $upcs;

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
    protected $warranty;

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

    public function getBindingEntity(): AmazonEntity\Binding
    {
        return $this->bindingEntity;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getBrowseNodeProducts(): array
    {
        return $this->browseNodeProducts;
    }

    /**
     * @deprecated Use ::getBrowseNodeProducts() instead
     */
    public function getBrowseNodes(): array
    {
        return $this->browseNodes;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function getEans(): array
    {
        return $this->eans;
    }

    public function getFeatures(): array
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

    public function getIsEligibleForTradeIn(): bool
    {
        return $this->isEligibleForTradeIn;
    }

    public function getIsValid(): bool
    {
        return $this->isValid;
    }

    public function getIsbns(): array
    {
        return $this->isbns;
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

    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getModified(): DateTime
    {
        return $this->modified;
    }

    public function getOffers(): array
    {
        return $this->offers;
    }

    public function getPartNumber(): string
    {
        return $this->partNumber;
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

    public function getSize(): string
    {
        return $this->size;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTradeInPrice(): float
    {
        return $this->tradeInPrice;
    }

    public function getUnitCount(): int
    {
        return $this->unitCount;
    }

    public function getUpcs(): array
    {
        return $this->upcs;
    }

    public function getVariantImages(): array
    {
        return $this->variantImages;
    }

    public function getVideoGenerated(): DateTime
    {
        return $this->videoGenerated;
    }

    public function getWarranty(): string
    {
        return $this->warranty;
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

    public function setAsin(string $asin): self
    {
        $this->asin = $asin;
        return $this;
    }

    public function setBindingEntity(
        AmazonEntity\Binding $bindingEntity
    ): self {
        $this->bindingEntity = $bindingEntity;
        return $this;
    }

    public function setBrand(
        string $brand
    ): self {
        $this->brand = $brand;
        return $this;
    }

    public function setBrowseNodeProducts(array $browseNodeProducts): self
    {
        $this->browseNodeProducts = $browseNodeProducts;
        return $this;
    }

    /**
     * @deprecated Use ::setBrowseNodeProducts() instead
     */
    public function setBrowseNodes(array $browseNodes): self
    {
        $this->browseNodes = $browseNodes;
        return $this;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function setCreated(DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function setEans(array $eans): self
    {
        $this->eans = $eans;
        return $this;
    }

    public function setFeatures(array $features): self
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

    public function setHiResImages(array $hiResImages): self
    {
        $this->hiResImages = $hiResImages;
        return $this;
    }

    public function setHiResImagesRetrieved(
        DateTime $hiResImagesRetrieved
    ): self {
        $this->hiResImagesRetrieved = $hiResImagesRetrieved;
        return $this;
    }

    public function setIsAdultProduct(bool $isAdultProduct): self
    {
        $this->isAdultProduct = $isAdultProduct;
        return $this;
    }

    public function setIsEligibleForTradeIn(bool $isEligibleForTradeIn): self
    {
        $this->isEligibleForTradeIn = $isEligibleForTradeIn;
        return $this;
    }

    public function setIsbns(array $isbns): self
    {
        $this->isbns = $isbns;
        return $this;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;
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

    public function setListPrice(float $listPrice): self
    {
        $this->listPrice = $listPrice;
        return $this;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;
        return $this;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function setModified(DateTime $modified): self
    {
        $this->modified = $modified;
        return $this;
    }

    public function setOffers(array $offers): self
    {
        $this->offers = $offers;
        return $this;
    }

    public function setPartNumber(string $partNumber): self
    {
        $this->partNumber = $partNumber;
        return $this;
    }

    public function setPrimaryImage(
        ImageEntity\Image $primaryImage
    ): self {
        $this->primaryImage = $primaryImage;
        return $this;
    }

    public function setProductId(int $productId): self
    {
        $this->productId = $productId;
        return $this;
    }

    public function setProductGroup(
        AmazonEntity\ProductGroup $productGroup
    ): self {
        $this->productGroup = $productGroup;
        return $this;
    }

    public function setReleased(DateTime $released): self
    {
        $this->released = $released;
        return $this;
    }

    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setTradeInPrice(float $tradeInPrice): self
    {
        $this->tradeInPrice = $tradeInPrice;
        return $this;
    }

    public function setUnitCount(int $unitCount): self
    {
        $this->unitCount = $unitCount;
        return $this;
    }

    public function setUpcs(array $upcs): self
    {
        $this->upcs = $upcs;
        return $this;
    }

    public function setVariantImages(array $variantImages): self
    {
        $this->variantImages = $variantImages;
        return $this;
    }

    public function setVideoGenerated(DateTime $videoGenerated): self
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

    public function setWarranty(string $warranty): self
    {
        $this->warranty = $warranty;
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
