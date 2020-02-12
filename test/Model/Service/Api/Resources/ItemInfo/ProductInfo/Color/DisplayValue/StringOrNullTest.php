<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ProductInfo\Color\DisplayValue;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class StringOrNullTest extends TestCase
{
    protected function setUp()
    {
        $this->stringOrNullService = new AmazonService\Api\Resources\ItemInfo\ProductInfo\Color\DisplayValue\StringOrNull();
    }

    public function testGetStringOrNull()
    {
        $itemInfoArray = array();

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'ReleaseDate' =>
            array (
              'DisplayValue' => '2019-05-22T01:00:01Z',
              'Label' => 'ReleaseDate',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Color' =>
            array (
              'DisplayValue' => 'RED',
              'Label' => 'Color',
              'Locale' => 'en_US',
            ),
            'ReleaseDate' =>
            array (
              'DisplayValue' => '2019-05-22T01:00:01Z',
              'Label' => 'ReleaseDate',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            'RED',
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $stringOfLength255 = '2EwmDVfFrfcXmWpLNaFdkwWDYaTdBA6cDff1Xs1VYfNKuQ6Xb5QYqKNjdmIO8XeF9b0jwwnGqf37NRU5pksLXM1GKtBCrKtni6cEuJdvxrgFQhupO8rj0aXaKu5Ia5ssjf3M512mM9cJoUYj8RZwF8Us0HN8QGNs301kOWYlWzp5Ljd64721v8HLjvXkjrrZBrLzA4zJxSX2SU4yVVMRZcbRNthtnlqAi2SuS2azcr4anj6TqHKlFWpHN21BPGm';
        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Color' =>
            array (
              'DisplayValue' => $stringOfLength255,
              'Label' => 'Color',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            $stringOfLength255,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );

        $stringOfLength256 = 'opwEIXmCnpPwatj7yNmYV3AvlJiX9mdOrCzz9Fp67mDVYjiyKHgp0u2xADRsCGLO5my0a3WTskDIlmkiiQZquf5TU40qQBnl7dWkFxpE2yQUIcooCjq6MeSzn65JAI72ZZ9MGbLeI1HEHn9IoRVkMkSfjTo9F7vBpmkLmrqWSJ9ueWL5zuIRZDK5WanNqavzXwpS2wM6vx8Zhuu2FqJRPLE24mgkHRbdy8JTxqMrsYDvjQkeKSYja9rXPJEDUO7v';
        $itemInfoArray = array(
          'ProductInfo' =>
          array (
            'Color' =>
            array (
              'DisplayValue' => $stringOfLength256,
              'Label' => 'Color',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($itemInfoArray)
        );
    }
}
