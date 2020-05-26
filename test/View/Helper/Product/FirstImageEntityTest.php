<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use PHPUnit\Framework\TestCase;

class FirstImageEntityTest extends TestCase
{
    protected function setUp(): void
    {
        $this->firstImageEntityServiceMock = $this->createMock(
            AmazonService\Product\FirstImageEntity::class
        );
        $this->firstImageEntityHelper = new AmazonHelper\Product\FirstImageEntity(
            $this->firstImageEntityServiceMock
        );
    }

    public function testInvoke()
    {
        $imageEntity = new ImageEntity\Image();

        $this->firstImageEntityServiceMock
            ->method('getFirstImageEntity')
            ->willReturn(
                $imageEntity
            );

        $this->assertSame(
            $imageEntity,
            $this->firstImageEntityHelper->__invoke(new AmazonEntity\Product())
        );
    }
}
