<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Images;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->productImageTableMock = $this->createMock(
            AmazonTable\ProductImage::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Images\SaveArrayToMySql(
            $this->productImageTableMock
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->productImageTableMock
            ->expects($this->exactly(1))
            ->method('insertIgnore')
            ->with(
                12345,
                'primary',
                'https://m.media-amazon.com/images/I/41vMYgD92xL.jpg',
                500,
                324
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getArray(),
            12345
        );
    }

    protected function getArray(): array
    {
        return array (
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
            2 =>
            array (
              'Large' =>
              array (
                'Height' => 500,
                'URL' => 'https://m.media-amazon.com/images/I/41iOxQN6I9L.jpg',
                'Width' => 500,
              ),
            ),
            3 =>
            array (
              'Large' =>
              array (
                'Height' => 500,
                'URL' => 'https://m.media-amazon.com/images/I/51PKoqY7C-L.jpg',
                'Width' => 500,
              ),
            ),
            4 =>
            array (
              'Large' =>
              array (
                'Height' => 362,
                'URL' => 'https://m.media-amazon.com/images/I/51CVXs285AL.jpg',
                'Width' => 500,
              ),
            ),
            5 =>
            array (
              'Large' =>
              array (
                'Height' => 324,
                'URL' => 'https://m.media-amazon.com/images/I/41lO9jk4+yL.jpg',
                'Width' => 500,
              ),
            ),
            6 =>
            array (
              'Large' =>
              array (
                'Height' => 337,
                'URL' => 'https://m.media-amazon.com/images/I/417XsD1JhuL.jpg',
                'Width' => 500,
              ),
            ),
            7 =>
            array (
              'Large' =>
              array (
                'Height' => 497,
                'URL' => 'https://m.media-amazon.com/images/I/31TYjFoBLSL.jpg',
                'Width' => 500,
              ),
            ),
            8 =>
            array (
              'Large' =>
              array (
                'Height' => 497,
                'URL' => 'https://m.media-amazon.com/images/I/21Vl8wxTI+L.jpg',
                'Width' => 500,
              ),
            ),
            9 =>
            array (
              'Large' =>
              array (
                'Height' => 301,
                'URL' => 'https://m.media-amazon.com/images/I/31U2cB8AvvL.jpg',
                'Width' => 500,
              ),
            ),
            10 =>
            array (
              'Large' =>
              array (
                'Height' => 348,
                'URL' => 'https://m.media-amazon.com/images/I/31tsD1UWlSL.jpg',
                'Width' => 500,
              ),
            ),
          ),
        );
    }
}
