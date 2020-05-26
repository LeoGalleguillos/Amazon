<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    protected function setUp(): void
    {
        $this->titleService = new AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Title();
    }

    public function test_shouldArrayBeSkipped_emptyArray_true()
    {
        $this->assertTrue(
            $this->titleService->shouldArrayBeSkipped(
                []
            )
        );
    }

    public function test_shouldArrayBeSkipped_emptyTitle_true()
    {
        $this->assertTrue(
            $this->titleService->shouldArrayBeSkipped(
                $this->getArrayWithEmptyTitle()
            )
        );
    }

    public function test_shouldArrayBeSkipped_validTitle_false()
    {
        $this->assertFalse(
            $this->titleService->shouldArrayBeSkipped(
                $this->getArrayWithValidTitle()
            )
        );
    }

    public function test_shouldArrayBeSkipped_titleLongerThan255Characters_true()
    {
        $this->assertTrue(
            $this->titleService->shouldArrayBeSkipped(
                $this->getArrayWithTitleLongerThan255Characters()
            )
        );
    }

    protected function getArrayWithEmptyTitle(): array
    {
        return array (
          'ItemInfo' =>
          array (
            'Title' =>
            array (
              'DisplayValue' => '',
              'Label' => 'Title',
              'Locale' => 'en_US',
            ),
          ),
        );
    }

    protected function getArrayWithValidTitle(): array
    {
        return array (
          'ItemInfo' =>
          array (
            'Title' =>
            array (
              'DisplayValue' => 'Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit',
              'Label' => 'Title',
              'Locale' => 'en_US',
            ),
          ),
        );
    }

    protected function getArrayWithTitleLongerThan255Characters(): array
    {
        return array (
          'ItemInfo' =>
          array (
            'Title' =>
            array (
              'DisplayValue' => 'Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit',
              'Label' => 'Title',
              'Locale' => 'en_US',
            ),
          ),
        );
    }
}
