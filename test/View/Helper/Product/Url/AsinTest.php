<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product\Url;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class AsinTest extends TestCase
{
    protected function setUp()
    {
        $this->asinServiceMock = $this->createMock(
            AmazonService\Product\Url\Asin::class
        );
        $this->productAsinUrlHelper = new AmazonHelper\Product\Url\Asin(
            $this->asinServiceMock
        );
    }

    public function testInvoke()
    {
        $this->asinServiceMock
            ->method('getUrl')
            ->willReturn(
                'https://www.example.com/watch/ASIN001/awesome-product'
            );

        $this->assertSame(
            'https://www.example.com/watch/ASIN001/awesome-product',
            $this->productAsinUrlHelper->__invoke(new AmazonEntity\Product())
        );
    }
}
