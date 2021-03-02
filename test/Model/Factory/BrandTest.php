<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    protected function setUp(): void
    {
        $this->brandFactory = new AmazonFactory\Brand();
    }

    public function test_buildFromName_brandEntity()
    {
        $brandEntity = (new AmazonEntity\Brand())
            ->setName('Name')
            ->setSlug('Name');
        $this->assertEquals(
            $brandEntity,
            $this->brandFactory->buildFromName('Name')
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
