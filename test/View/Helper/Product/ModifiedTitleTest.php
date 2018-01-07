<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedTitleTest extends TestCase
{
    protected function setUp()
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
}
