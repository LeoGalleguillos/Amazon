<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class ImagesTest extends TestCase
{
    protected function setUp()
    {
        $this->imagesService = new AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Images();
    }

    public function test_shouldArrayBeSkipped_emptyArray_true()
    {
        $this->assertTrue(
            $this->imagesService->shouldArrayBeSkipped(
                []
            )
        );
    }

    public function test_shouldArrayBeSkipped_noPrimaryImage_true()
    {
        $this->assertTrue(
            $this->imagesService->shouldArrayBeSkipped(
                $this->getArrayWithVariantImages()
            )
        );
    }

    public function test_shouldArrayBeSkipped_noVariantImages_true()
    {
        $this->assertTrue(
            $this->imagesService->shouldArrayBeSkipped(
                $this->getArrayWithPrimaryImage()
            )
        );
    }

    public function test_shouldArrayBeSkipped_primaryAndVariantImages_false()
    {
        $this->assertFalse(
            $this->imagesService->shouldArrayBeSkipped(
                $this->getArrayWithPrimaryAndVariantImages()
            )
        );
    }

    protected function getArrayWithPrimaryImage(): array
    {
        return array (
            'ASIN' => 'B07RF1XD36',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 324,
                  'URL' => 'https://m.media-amazon.com/images/I/41vMYgD92xL.jpg',
                  'Width' => 500,
                ),
              ),
              'Variants' =>
              array (
              ),
            ),
        );
    }

    protected function getArrayWithVariantImages(): array
    {
        return array (
            'ASIN' => 'B07RF1XD36',
            'Images' =>
            array (
              'Primary' =>
              array (
              ),
              'Variants' =>
              array (
                0 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51gXsXwdbcL.jpg',
                    'Width' => 500,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51FFQpin2JL.jpg',
                    'Width' => 500,
                  ),
                ),
              ),
            ),
        );
    }

    protected function getArrayWithPrimaryAndVariantImages(): array
    {
        return array (
            'ASIN' => 'B07RF1XD36',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 324,
                  'URL' => 'https://m.media-amazon.com/images/I/41vMYgD92xL.jpg',
                  'Width' => 500,
                ),
              ),
              'Variants' =>
              array (
                0 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51gXsXwdbcL.jpg',
                    'Width' => 500,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51FFQpin2JL.jpg',
                    'Width' => 500,
                  ),
                ),
              ),
            ),
        );
    }
}
