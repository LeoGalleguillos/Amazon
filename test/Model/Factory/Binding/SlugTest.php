<?php
namespace LeoGalleguillos\AmazonTest\Model\Factory\Binding;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SlugTest extends TestCase
{
    protected function setUp(): void
    {
        $this->bindingTableMock = $this->createMock(
            AmazonTable\Binding::class
        );
        $this->slugFactory = new AmazonFactory\Binding\Slug(
            $this->bindingTableMock
        );
    }

    public function test_buildFromSlug_bindingEntity()
    {
        $bindingEntity = (new AmazonEntity\Binding())
            ->setName('Name')
            ->setSlug('slug')
            ;
        $this->bindingTableMock
            ->expects($this->once())
            ->method('selectNameWhereSlugEquals')
            ->with('slug')
            ->willReturn('Name')
            ;
        $this->assertEquals(
            $bindingEntity,
            $this->slugFactory->buildFromSlug('slug')
        );
    }
}
