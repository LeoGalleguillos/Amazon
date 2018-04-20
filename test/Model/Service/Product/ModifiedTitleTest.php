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
        $brandEntity = new AmazonEntity\Brand('Example Brand', 'Example-Brand');

        $productEntity        = new AmazonEntity\Product();
        $productEntity->setTitle('Example Brand Amazing Product\'s Title (Is Great)');
        $productEntity->setBrandEntity($brandEntity);

        $this->assertSame(
            'Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle(' My Amazing   Product\'s Title   [Is Great]');
        $this->assertSame(
            'Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle('!This is a really long title! as it has more than nine words in it holy cow.');
        $this->assertSame(
            'This really long title has more than nine words',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle('Ratchet Noise maker Plastic 25 X 25 Pack Of 20');
        $this->assertSame(
            'Ratchet Noise maker Plastic Pack',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle('Google Android Series With AND with');
        $this->assertSame(
            'Google Android Series',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );
    }
}
