<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Brand
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $slug;

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setName(string $name): AmazonEntity\Brand
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug): AmazonEntity\Brand
    {
        $this->slug = $slug;
        return $this;
    }
}
