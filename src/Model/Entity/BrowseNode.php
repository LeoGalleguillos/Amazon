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

    public function getName(): string
    {
        return $this->name;
    }

    public function setBrowseNodeId(int $browseNodeId): AmazonEntity\BrowseNode
    {
        $this->browseNodeId = $browseNodeId;
        return $this;
    }

    public function setName(string $name): AmazonEntity\BrowseNode
    {
        $this->name = $name;
        return $this;
    }
}
