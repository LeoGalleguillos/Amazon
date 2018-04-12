<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

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
}
