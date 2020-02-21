<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ManufactureInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    protected function setUp()
    {
        $this->setService = new AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Set();
    }

    public function testGetSet()
    {
        $this->assertInternalType(
            'array',
            $this->setService->getSet([])
        );
    }
}
