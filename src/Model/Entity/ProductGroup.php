<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

class ProductGroup
{
    /**
     * @var bool Whether the product is in stock.
     */
    public $name;

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
}
