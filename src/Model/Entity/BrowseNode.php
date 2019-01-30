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
     * @var string
     */
    protected $name;

    public function getBrowseNodeId(): int
    {
        return $this->browseNodeId;
    }

    public function getChild(): AmazonEntity\BrowseNode
    {
        return $this->child;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): AmazonEntity\BrowseNode
    {
        return $this->parent;
    }

    public function setBrowseNodeId(int $browseNodeId): AmazonEntity\BrowseNode
    {
        $this->browseNodeId = $browseNodeId;
        return $this;
    }

    public function setChild(AmazonEntity\BrowseNode $child): AmazonEntity\BrowseNode
    {
        $this->child = $child;
        return $this;
    }

    public function setName(string $name): AmazonEntity\BrowseNode
    {
        $this->name = $name;
        return $this;
    }

    public function setParent(AmazonEntity\BrowseNode $parent): AmazonEntity\BrowseNode
    {
        $this->parent = $parent;
        return $this;
    }
}
