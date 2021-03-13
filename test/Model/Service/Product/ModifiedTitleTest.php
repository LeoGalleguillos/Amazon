<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ModifiedTitleTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productModifiedTitleService = new AmazonService\Product\ModifiedTitle();
    }

    public function test_getModifiedTitle()
    {
        $productEntity        = new AmazonEntity\Product();
        $productEntity->setTitle('Example Brand Amazing Product\'s Title (Is Great)');

        $this->assertSame(
            'Example Brand Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle(' My Amazing   Product\'s Title   [Is Great]');
        $this->assertSame(
            'Amazing Products Title',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle('!This is a really long title! It has a lot of words in it but only the first pre-determined number of words should be stored in the title because otherwise there would be too many words in the title');
        $this->assertSame(
            'This really long title has lot words but only the first predetermined number words should stored the title because otherwise',
            $this->productModifiedTitleService->getModifiedTitle($productEntity)
        );

        $productEntity->setTitle('(2 Pack) Headphone');
        $this->assertSame(
            'Headphone',
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
