<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Binding
{
    /**
     * @var string Name of binding.
     */
    public $name;

    /**
     * @var string Slug of binding.
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

    public function getBindingId() : int
    {
        return $this->bindingId;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getSlug() : string
    {
        return $this->slug;
    }

    public function setName(string $name) : AmazonEntity\Binding
    {
        $this->name = $name;
        return this;
    }

    public function setSlug(string $slug) : AmazonEntity\Binding
    {
        $this->slug = $slug;
        return this;
    }
}
