<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Brand
{
    /**
     * @var string Name of brand.
     */
    public $name;

    /**
     * @var string Slug of brand.
     */
    public $slug;

    public function __construct($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getBrandId() : int
    {
        return $this->brandId;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : AmazonEntity\Brand
    {
        $this->name = $name;
        return this;
    }
}
