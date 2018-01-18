<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Word\Model\Entity as WordEntity;
use LeoGalleguillos\Word\Model\Service as WordService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ModifiedFeatureTest extends TestCase
{
    protected function setUp()
    {
        $this->capitalizationServiceMock = $this->createMock(
            WordService\Capitalization::class
        );
        $this->thesaurusServiceMock = $this->createMock(
            WordService\Thesaurus::class
        );
        $this->wordServiceMock = $this->createMock(
            WordService\Word::class
        );
        $this->productModifiedFeatureHelper = new AmazonHelper\Product\ModifiedFeature(
            $this->capitalizationServiceMock,
            $this->thesaurusServiceMock,
            $this->wordServiceMock
        );

        $this->wordEntity1         = new WordEntity\Word();
        $this->wordEntity1->wordId = 1;
        $this->wordEntity1->word   = 'test';

        $this->wordEntity2         = new WordEntity\Word();
        $this->wordEntity2->wordId = 2;
        $this->wordEntity2->word   = 'essay';

        $this->wordEntity3         = new WordEntity\Word();
        $this->wordEntity3->wordId = 3;
        $this->wordEntity3->word   = 'trial';
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
        $this->wordServiceMock->method('getEntityFromString')->willReturn(
            $this->wordEntity1
        );

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

        $this->wordServiceMock->method('getEntityFromString')->willReturn(
            $this->wordEntity1
        );
        $this->thesaurusServiceMock->method('getSynonyms')->willReturn(
            [$this->wordEntity2, $this->wordEntity3]
        );

        $this->wordEntity3->word = 'Trial';
        $this->capitalizationServiceMock->method('getCapitalization')->willReturn(
            new WordEntity\Capitalization\Uppercase()
        );
        $this->capitalizationServiceMock->method('setCapitalization')->willReturn(
            $this->wordEntity3
        );
        $this->capitalizationServiceMock
             ->expects($this->once())
             ->method('setCapitalization')
             ->with(
                $this->wordEntity3,
                $this->equalTo(new WordEntity\Capitalization\Uppercase())
             );

        $this->assertSame(
            'Trial 123 is our first test.',
            $reflectionMethod->invokeArgs(
                $this->productModifiedFeatureHelper,
                [$feature]
            )
        );
    }
}
