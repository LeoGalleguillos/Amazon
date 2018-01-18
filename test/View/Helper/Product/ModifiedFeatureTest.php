<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Word\Model\Service as WordService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ModifiedFeatureTest extends TestCase
{
    protected function setUp()
    {
        $capitalizationServiceMock = $this->createMock(
            WordService\Capitalization::class
        );
        $thesaurusServiceMock = $this->createMock(
            WordService\Thesaurus::class
        );
        $this->productModifiedFeatureHelper = new AmazonHelper\Product\ModifiedFeature(
            $capitalizationServiceMock,
            $thesaurusServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\Product\ModifiedFeature::class,
            $this->productModifiedFeatureHelper
        );
    }

    public function testInvoke()
    {
        $feature = 'This is a <i>feature</i> and it\'s great.';
        $modifiedFeature = $this->productModifiedFeatureHelper->__invoke(
            $feature
        );

        $this->assertSame(
            'Is a feature, it\'s great.',
            $modifiedFeature
        );
    }

    public function testReplaceFirstWord()
    {
        $reflectionClass  = new ReflectionClass($this->productModifiedFeatureHelper);
        $reflectionMethod = $reflectionClass->getMethod('replaceFirstWord');
        $reflectionMethod->setAccessible(true);

        $feature = 'Test 123 is our first test.';

        $this->assertSame(
            $feature,
            $reflectionMethod->invokeArgs(
                $this->productModifiedFeatureHelper,
                [$feature]
            )
        );
    }
}
