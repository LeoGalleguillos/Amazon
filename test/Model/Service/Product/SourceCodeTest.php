<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SourceCodeTest extends TestCase
{
    protected function setUp(): void
    {
        $this->sourceCodeService = new AmazonService\Product\SourceCode();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Product\SourceCode::class,
            $this->sourceCodeService
        );
    }

    public function testGetSourceCode()
    {
        $this->markTestSkipped('Skip test unless you want to call Amazon.');

        $productEntity = new AmazonEntity\Product();
        $productEntity->setAsin('B01HC9N5HG');

        $sourceCode = $this->sourceCodeService->getSourceCode(
            $productEntity
        );
    }
}
