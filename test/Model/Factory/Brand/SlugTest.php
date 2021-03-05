<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory\Brand;

use Exception;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use MonthlyBasis\LaminasTest\Hydrator as LaminasTestHydrator;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    protected function setUp(): void
    {
        $this->brandTableMock = $this->createMock(
            AmazonTable\Brand::class
        );
        $this->slugFactory = new AmazonFactory\Brand\Slug(
            $this->brandTableMock
        );
    }

    public function test_buildFromSlug_brandEntity()
    {
        $brandEntity = (new AmazonEntity\Brand())
            ->setName('Name')
            ->setSlug('slug')
            ;
        $resultMock = $this->createMock(
            Result::class
        );
        $hydrator = new LaminasTestHydrator\CountableIterator();
        $hydrator->hydrate(
            $resultMock,
            [
                [
                    'brand_id' => '1',
                    'name'     => 'Name',
                    'slug'     => 'slug',
                ],
            ]
        );
        $this->brandTableMock
            ->expects($this->once())
            ->method('selectWhereSlug')
            ->with('slug')
            ->willReturn($resultMock)
            ;
        $this->assertEquals(
            $brandEntity,
            $this->slugFactory->buildFromSlug('slug')
        );
    }

    public function test_buildFromSlug_throwException()
    {
        $resultMock = $this->createMock(
            Result::class
        );
        $hydrator = new LaminasTestHydrator\CountableIterator();
        $hydrator->hydrate(
            $resultMock,
            [
            ]
        );
        $this->brandTableMock
            ->expects($this->once())
            ->method('selectWhereSlug')
            ->with('slug')
            ->willReturn($resultMock)
            ;

        try {
            $this->slugFactory->buildFromSlug('slug');
            $this->fail();
        } catch (Exception $exception) {
            $this->assertSame(
                'Unable to build Brand because slug is not found.',
                $exception->getMessage()
            );
        }
    }
}
