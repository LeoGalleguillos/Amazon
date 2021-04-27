<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    protected function setUp(): void
    {
        $this->urlFriendlyServiceMock = $this->createMock(
            StringService\UrlFriendly::class
        );
        $this->brandFactory = new AmazonFactory\Brand(
            $this->urlFriendlyServiceMock
        );
    }

    public function test_buildFromName_brandEntity()
    {
        $this->urlFriendlyServiceMock
            ->expects($this->once())
            ->method('getUrlFriendly')
            ->with('Brand Name')
            ->willReturn('Brand-Name')
            ;
        $brandEntity = (new AmazonEntity\Brand())
            ->setName('Brand Name')
            ->setSlug('Brand-Name');
        $this->assertEquals(
            $brandEntity,
            $this->brandFactory->buildFromName('Brand Name')
        );
    }

    public function test_buildFromName_throwsException()
    {
        try {
            $this->brandFactory->buildFromName('');
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Unable to build because name is empty.',
                $exception->getMessage()
            );
        }
    }
}
