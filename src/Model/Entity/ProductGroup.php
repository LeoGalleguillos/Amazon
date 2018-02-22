<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class ProductGroup
{
    /**
     * @var bool Whether the product is in stock.
     */
    public $name;

    protected $searchTable;

    /**
     * @var array Array of product features.
     */
    public $slug;

    public function __construct($name = null, $slug = null)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getSearchTable() : string
    {
        return $this->searchTable;
    }

    public function setName(string $name) : AmazonEntity\ProductGroup
    {
        $this->name = $name;
        return $this;
    }

    public function setProductGroupId(int $productGroupId) : AmazonEntity\ProductGroup
    {
        $this->productGroupId = $productGroupId;
        return $this;
    }

    public function setSearchTable(string $searchTable) : AmazonEntity\ProductGroup
    {
        $this->searchTable = $searchTable;
        return $this;
    }

    public function setSlug(string $slug) : AmazonEntity\ProductGroup
    {
        $this->slug = $slug;
        return $this;
    }
}
