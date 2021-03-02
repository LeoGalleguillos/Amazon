<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    protected function setUp(): void
    {
        $this->brandEntity = new AmazonEntity\Brand();
    }

    public function testGettersAndSetters()
    {
        $name = 'Name';
        $this->assertSame(
            $this->brandEntity,
            $this->brandEntity->setName($name)
        );
        $this->assertSame(
            $name,
            $this->brandEntity->getName()
        );

        $slug = 'slug';
        $this->assertSame(
            $this->brandEntity,
            $this->brandEntity->setSlug($slug)
        );
        $this->assertSame(
            $slug,
            $this->brandEntity->getSlug()
        );
    }
}
