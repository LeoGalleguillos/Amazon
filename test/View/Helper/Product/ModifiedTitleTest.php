<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedTitleTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productModifiedTitleService = $this->createMock(
            AmazonService\Product\ModifiedTitle::class
        );
        $this->productModifiedTitleHelper = new AmazonHelper\Product\ModifiedTitle(
            $this->productModifiedTitleService
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\ModifiedTitle::class,
            $this->productModifiedTitleHelper
        );
    }

    public function testInvoke()
    {
        $this->productModifiedTitleService->method('getModifiedTitle')->willReturn(
            'The Modified Title'
        );
        $modifiedTitle = $this->productModifiedTitleHelper->__invoke(
            new AmazonEntity\Product()
        );
        $this->assertSame(
            'The Modified Title',
            $modifiedTitle
        );
    }
}
