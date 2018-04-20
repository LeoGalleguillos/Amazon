<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Brand
{
    /**
     * @var int
     */
    protected $brandId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
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

    public function getSlug() : string
    {
        return $this->slug;
    }

    public function setBrandId(int $brandId) : AmazonEntity\Brand
    {
        $this->brandId = $brandId;
        return this;
    }

    public function setName(string $name) : AmazonEntity\Brand
    {
        $this->name = $name;
        return this;
    }

    public function setSlug(string $slug) : AmazonEntity\Brand
    {
        $this->slug = $slug;
        return this;
    }
}
