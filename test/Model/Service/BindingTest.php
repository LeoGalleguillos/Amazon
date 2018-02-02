<?php
namespace LeoGalleguillos\AmazonTest\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class BindingTest extends TestCase
{
    protected function setUp()
    {
        $this->productFactoryMock = $this->createMock(AmazonFactory\Product::class);
        $this->bindingTableMock   = $this->createMock(AmazonTable\Binding::class);

        $this->bindingService = new AmazonService\Binding(
            $this->productFactoryMock,
            $this->bindingTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonService\Binding::class,
            $this->bindingService
        );
    }
}
