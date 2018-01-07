<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ModifiedTitleTest extends TestCase
{
    protected function setUp()
    {
        $this->productModifiedTitleService = new AmazonService\Product\ModifiedTitle();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\ModifiedTitle::class,
            $this->productModifiedTitleService
        );
    }

    public function testGetModifiedTitle()
    {
        $productEntity = new AmazonEntity\Product();
        $productEntity->title = 'My Amazing Title';

        $this->assertSame(
            'My Amazing Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );
    }
}
