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
        $this->replaceWordsServiceMock = $this->createMock(
            SentenceService\ReplaceWords::class
        );
        $this->productModifiedFeatureHelper = new AmazonHelper\Product\ModifiedFeature(
            $this->replaceWordsServiceMock
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
        $this->replaceWordsServiceMock->method('replaceWords')->willReturn('ok');
        $feature = 'This is a <i>feature</i> and it\'s great.';
        $modifiedFeature = $this->productModifiedFeatureHelper->__invoke(
            $feature
        );

        $this->assertSame(
            'ok',
            $modifiedFeature
        );
    }
}
