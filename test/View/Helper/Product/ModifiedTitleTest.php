<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use ArrayObject;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedTitleTest extends TestCase
{
    protected function setUp()
    {
        $this->productModifiedTitleHelper = new AmazonHelper\Product\ModifiedTitle();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\ModifiedTitle::class,
            $this->productModifiedTitleHelper
        );
    }
}
