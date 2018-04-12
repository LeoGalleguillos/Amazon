<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

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
}
