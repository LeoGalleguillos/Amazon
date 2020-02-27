<?php
namespace LeoGalleguillos\Amazon\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

/**
 * Stores browse node and meta data about relationship between browse node and
 * product such as sales rank and order.
 */
class BrowseNodeProduct
{
    /**
     * @var int
     */
    protected $order;

    /**
     * @var int
     */
    protected $salesRank;

    /**
     * @var AmazonEntity\BrowseNode
     */
    protected $browseNode;

    public function getBrowseNode(): AmazonEntity\BrowseNode
    {
        return $this->browseNode;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getSalesRank(): int
    {
        return $this->salesRank;
    }

    public function setBrowseNode(
        AmazonEntity\BrowseNode $browseNode
    ): self {
        $this->browseNode = $browseNode;
        return $this;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setSalesRank(int $salesRank): self
    {
        $this->salesRank = $salesRank;
        return $this;
    }
}
