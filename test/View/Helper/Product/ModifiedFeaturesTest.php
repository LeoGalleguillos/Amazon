<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedFeaturesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productModifiedFeatureHelperMock = $this->createMock(
            AmazonHelper\Product\ModifiedFeature::class
        );
        $this->productModifiedFeaturesHelper = new AmazonHelper\Product\ModifiedFeatures(
            $this->productModifiedFeatureHelperMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\ModifiedFeatures::class,
            $this->productModifiedFeaturesHelper
        );
    }

    public function testInvoke()
    {
        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            [],
            $this->productModifiedFeaturesHelper->__invoke($productEntity)
        );

        $productEntity->features = [
            'First feature',
        ];
        $this->productModifiedFeatureHelperMock->method('__invoke')->will($this->returnCallback(
            function ($string) {
                return $string . ' modified';
            }
        ));

        $this->assertSame(
            [
                'First feature modified',
            ],
            $this->productModifiedFeaturesHelper->__invoke($productEntity)
        );

        $productEntity->features = [
            'First feature',
            'Second feature',
            'Third feature',
        ];
        $this->assertSame(
            [
                'Third feature modified',
                'Second feature modified',
                'First feature modified',
            ],
            $this->productModifiedFeaturesHelper->__invoke($productEntity)
        );
    }
}
