<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class BrowseNode
{
    /**
     * @var int
     */
    protected $browseNodeId;

    /**
     * @var array
     */
    protected $children;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $parents;

    public function getBrowseNodeId(): int
    {
        return $this->browseNodeId;
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParents(): array
    {
        return $this->parents;
    }

    public function setBrowseNodeId(int $browseNodeId): AmazonEntity\BrowseNode
    {
        $this->browseNodeId = $browseNodeId;
        return $this;
    }

    public function setChildren(array $children): AmazonEntity\BrowseNode
    {
        $this->children = $children;
        return $this;
    }

    public function setName(string $name): AmazonEntity\BrowseNode
    {
        $this->name = $name;
        return $this;
    }

    public function setParents(array $parents): AmazonEntity\BrowseNode
    {
        $this->parents = $parents;
        return $this;
    }
}
