<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;

class BrowseNodeProductTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeProductEntity = new AmazonEntity\BrowseNodeProduct();
    }

    public function testGettersAndSetters()
    {
        $browseNodeEntity = new AmazonEntity\BrowseNode();
        $this->assertSame(
            $this->browseNodeProductEntity,
            $this->browseNodeProductEntity->setBrowseNode($browseNodeEntity)
        );
        $this->assertSame(
            $browseNodeEntity,
            $this->browseNodeProductEntity->getBrowseNode()
        );

        $order = 8;
        $this->assertSame(
            $this->browseNodeProductEntity,
            $this->browseNodeProductEntity->setOrder($order)
        );
        $this->assertSame(
            $order,
            $this->browseNodeProductEntity->getOrder()
        );

        $salesRank = 1024;
        $this->assertSame(
            $this->browseNodeProductEntity,
            $this->browseNodeProductEntity->setSalesRank($salesRank)
        );
        $this->assertSame(
            $salesRank,
            $this->browseNodeProductEntity->getSalesRank()
        );
    }
}
