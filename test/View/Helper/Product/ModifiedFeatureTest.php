<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Sentence\Model\Service as SentenceService;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ModifiedFeatureTest extends TestCase
{
    protected function setUp()
    {
        $this->productModifiedFeatureHelper = new AmazonHelper\Product\ModifiedFeature();
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
}
