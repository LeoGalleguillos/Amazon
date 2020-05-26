<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Images;

use Laminas\Db\Adapter\Driver\Pdo\Connection;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp(): void
    {
        $this->productImageTableMock = $this->createMock(
            AmazonTable\ProductImage::class
        );
        $this->connectionMock = $this->createMock(
            Connection::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Images\SaveArrayToMySql(
            $this->productImageTableMock,
            $this->connectionMock
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('beginTransaction');
        $this->productImageTableMock
            ->expects($this->exactly(1))
            ->method('deletewhereProductId')
            ->with(12345);
        $this->productImageTableMock
            ->expects($this->exactly(3))
            ->method('insertIgnore')
            ->withConsecutive(
                [
                    12345,
                    'primary',
                    'https://m.media-amazon.com/images/I/41vMYgD92xL.jpg',
                    500,
                    324,
                ],
                [
                    12345,
                    'variant',
                    'https://m.media-amazon.com/images/I/51gXsXwdbcL.jpg',
                    500,
                    500,
                ],
                [
                    12345,
                    'variant',
                    'https://m.media-amazon.com/images/I/51FFQpin2JL.jpg',
                    500,
                    500,
                ]
            );
        $this->connectionMock
            ->expects($this->exactly(1))
            ->method('commit');

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
          ),
        );
    }
}
