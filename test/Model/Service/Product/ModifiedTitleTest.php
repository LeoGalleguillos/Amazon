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
        $productEntity        = new AmazonEntity\Product();
        $productEntity->title = 'My Amazing Product\'s Title (Is Great)';
        $productEntity->brand = new AmazonEntity\Brand('My', 'My');

        $this->assertSame(
            'Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->title = 'My Amazing Product\'s Title [Is Great]';
        $this->assertSame(
            'Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->title = 'This is a really long title with more than nine words in it.';
        $this->assertSame(
            'This is a really long title with more than',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );
    }
}
