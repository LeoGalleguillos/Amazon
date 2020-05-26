<?php
namespace LeoGalleguillos\AmazonTest\View\Helper\Product;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use PHPUnit\Framework\TestCase;

class ModifiedOrCreatedTest extends TestCase
{
    protected function setUp(): void
    {
        $this->modifiedOrCreatedHelper = new AmazonHelper\Product\ModifiedOrCreated();
    }

    public function test___invoke_modifiedIsSet_getModified()
    {
        $created  = new DateTime();
        $modified = new DateTime();

        $productEntity = (new AmazonEntity\Product())
            ->setCreated($created)
            ->setModified($modified);

        $this->assertSame(
            $modified,
            $this->modifiedOrCreatedHelper->__invoke($productEntity)
        );
    }

    public function test___invoke_modifiedIsNotSet_getCreated()
    {
        $created = new DateTime();

        $productEntity = (new AmazonEntity\Product())
            ->setCreated($created);

        $this->assertSame(
            $created,
            $this->modifiedOrCreatedHelper->__invoke($productEntity)
        );
    }
}
