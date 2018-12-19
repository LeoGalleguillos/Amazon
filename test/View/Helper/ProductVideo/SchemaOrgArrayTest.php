<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class SchemaOrgArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->modifiedTitleServiceMock = $this->createMock(
            AmazonService\Product\ModifiedTitle::class
        );
        $this->slugServiceMock = $this->createMock(
            AmazonService\Product\Slug::class
        );

        $this->schemaOrgArrayHelper = new AmazonHelper\ProductVideo\SchemaOrgArray(
            $this->modifiedTitleServiceMock,
            $this->slugServiceMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            AmazonHelper\ProductVideo\SchemaOrgArray::class,
            $this->schemaOrgArrayHelper
        );
    }
}
