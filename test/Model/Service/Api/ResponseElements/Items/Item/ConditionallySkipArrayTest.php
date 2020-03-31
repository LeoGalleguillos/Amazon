<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items\Item;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ConditionallySkipArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->imagesServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Images::class
        );
        $this->parentAsinServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\ParentAsin::class
        );
        $this->titleServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Title::class
        );
        $this->bannedServiceMock = $this->createMock(
            AmazonService\Product\Banned::class
        );

        $this->conditionallySkipArrayService = new AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray(
            $this->imagesServiceMock,
            $this->parentAsinServiceMock,
            $this->titleServiceMock,
            $this->bannedServiceMock
        );
    }

    public function test_shouldArrayBeSkipped_emptyArray_true()
    {
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                []
            )
        );
    }

    public function test_shouldArrayBeSkipped_asinThatDoesNotStartWithB_true()
    {
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWithAsinThatDoesNotStartWithB()
            )
        );
    }

    public function test_shouldArrayBeSkipped_asinIsBanned_true()
    {
        $this->bannedServiceMock
            ->expects($this->exactly(1))
            ->method('isBanned')
            ->with('B07RF1XD36')
            ->willReturn(true);
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWithAsinThatStartsWithB()
            )
        );
    }

    public function test_shouldArrayBeSkipped_imagesShouldBeSkipped_true()
    {
        $this->imagesServiceMock
            ->expects($this->exactly(1))
            ->method('shouldArrayBeSkipped')
            ->with($this->getMinimalArray())
            ->willReturn(true);
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getMinimalArray()
            )
        );
    }

    public function test_shouldArrayBeSkipped_parentAsinShouldBeSkipped_true()
    {
        $this->parentAsinServiceMock
            ->expects($this->exactly(1))
            ->method('shouldArrayBeSkipped')
            ->with($this->getMinimalArray())
            ->willReturn(true);
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getMinimalArray()
            )
        );
    }

    public function test_shouldArrayBeSkipped_titleShouldBeSkipped_true()
    {
        $this->titleServiceMock
            ->expects($this->exactly(1))
            ->method('shouldArrayBeSkipped')
            ->with($this->getMinimalArray())
            ->willReturn(true);
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getMinimalArray()
            )
        );
    }

    public function test_shouldArrayBeSkipped_isAdultProductTrue_true()
    {
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWithIsAdultProductTrue()
            )
        );
    }

    public function test_shouldArrayBeSkipped_isAdultProductFalse_false()
    {
        $this->assertFalse(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWithIsAdultProductFalse()
            )
        );
    }

    public function test_shouldArrayBeSkipped_productGroupShouldBeSkipped_true()
    {
        $this->assertTrue(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWhereProductGroupShouldBeSkipped()
            )
        );
    }

    public function test_shouldArrayBeSkipped_productGroupShouldNotBeSkipped_false()
    {
        $this->assertFalse(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getArrayWhereProductGroupShouldNotBeSkipped()
            )
        );
    }

    public function test_shouldArrayBeSkipped_minimalArray_false()
    {
        $this->assertFalse(
            $this->conditionallySkipArrayService->shouldArrayBeSkipped(
                $this->getMinimalArray()
            )
        );
    }

    protected function getArrayWithAsinThatDoesNotStartWithB(): array
    {
        return array (
            'ASIN' => 'A07RF1XD36',
        );
    }

    protected function getArrayWithAsinThatStartsWithB(): array
    {
        return array (
            'ASIN' => 'B07RF1XD36',
        );
    }

    protected function getArrayWithIsAdultProductTrue(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
          'ItemInfo' =>
          array (
            'ProductInfo' =>
            array (
              'IsAdultProduct' =>
              array (
                'DisplayValue' => true,
                'Label' => 'IsAdultProduct',
                'Locale' => 'en_US',
              ),
            )
          )
        );
    }

    protected function getArrayWithIsAdultProductFalse(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
          'ItemInfo' =>
          array (
            'ProductInfo' =>
            array (
              'IsAdultProduct' =>
              array (
                'DisplayValue' => false,
                'Label' => 'IsAdultProduct',
                'Locale' => 'en_US',
              ),
            )
          )
        );
    }

    protected function getArrayWhereProductGroupShouldBeSkipped(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
          'ItemInfo' =>
          array (
            'Classifications' =>
            array (
              'ProductGroup' =>
              array (
                'DisplayValue' => 'Digital Music Purchase',
                'Label' => 'ProductGroup',
                'Locale' => 'en_US',
              ),
            ),
          ),
        );
    }

    protected function getArrayWhereProductGroupShouldNotBeSkipped(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
          'ItemInfo' =>
          array (
            'Classifications' =>
            array (
              'ProductGroup' =>
              array (
                'DisplayValue' => 'Apparel',
                'Label' => 'ProductGroup',
                'Locale' => 'en_US',
              ),
            ),
          ),
        );
    }

    protected function getMinimalArray(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
        );
    }
}
