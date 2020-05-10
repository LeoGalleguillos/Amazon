<?php
namespace LeoGalleguillos\AmazonTest\Model\Entity\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use PHPUnit\Framework\TestCase;

class ListingTest extends TestCase
{
    protected function setUp()
    {
        $this->listingEntity = new AmazonEntity\Resources\Offers\Listing();
    }

    public function test_instance()
    {
        $this->assertInstanceOf(
            AmazonEntity\Resources\Offers\Listing::class,
            $this->listingEntity
        );
    }
}
