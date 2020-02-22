<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\ItemInfo\ManufactureInfo\Warranty\DisplayValue;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class StringOrNullTest extends TestCase
{
    protected function setUp()
    {
        $this->stringOrNullService = new AmazonService\Api\Resources\ItemInfo\ManufactureInfo\Warranty\DisplayValue\StringOrNull();
    }

    public function testGetStringOrNull()
    {
        $manufactureInfoArray = array();

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($manufactureInfoArray)
        );

        $manufactureInfoArray = array(
          'ItemPartNumber' =>
          array (
            'DisplayValue' => '51120',
            'Label' => 'PartNumber',
            'Locale' => 'en_US',
          ),
          'Model' =>
          array (
            'DisplayValue' => 'ABCDEFG',
            'Label' => 'Model',
            'Locale' => 'en_US',
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($manufactureInfoArray)
        );

        $manufactureInfoArray = array(
          'ItemPartNumber' =>
          array (
            'DisplayValue' => '51120',
            'Label' => 'PartNumber',
            'Locale' => 'en_US',
          ),
          'Model' =>
          array (
            'DisplayValue' => 'ABCDEFG',
            'Label' => 'Model',
            'Locale' => 'en_US',
          ),
          'Warranty' =>
          array (
            'DisplayValue' => '1 year with full refund or replacement',
            'Label' => 'Warranty',
            'Locale' => 'en_US',
          ),
        );

        $this->assertSame(
            '1 year with full refund or replacement',
            $this->stringOrNullService->getStringOrNull($manufactureInfoArray)
        );

        $stringOfLength1023 = 'YarZaRwjJSS8ERtKbmrJIMi267Nk6tTzqPzZ62EP9nCwpQK5O5przEyL3ljyGLm2aQyQDSuOUERNLFFYvaXaD0FUu2x7233mRYMWtralF3Aw5lsuleEGV0Q7qaRQrO4QtbPJWls93TQ9KZibq7QBQqEdf9Xahwwu63mJbSqBbzUwSonneIRzU940g07AIaobMhUTkR4sitRuNKQcCbKIBMHZc9h9dq0zZBINH3p93fFTwELWZW7gt37D6lGqG4mjNsLIbTqiGO9QKc8q81myPxEbLBvz3pcWMWF56Tec4o75xaWHENz2471PtM46nhdKdwDa0LnIEGycWJdctJ4fqod6YVgHSUiL8OmmmyzubnXOxgwRjIsoTqN7ek6ugUYQ3MTd5wThnf5JF3Eug8TXomqza15wcmSPCHJ8ODMnRzITpIYIcVGpyLViExCZNPEWXavL5m20dIlqrYQqwmu8W1LhxUjSFBSee5d615rrVVA9m3rz3fNyr1d1uWvMJA7IaDPN1bxnEwxodxorjptXOZUIwkU9JYWbC9tgddwBaY4bkfsMVvK0XNsDj3Uyl3SFn6GvmONNaiXB7DDk1QpfRnzunpj7Zubfg6bwnplhJZ41Hn3vg4McUPDNgzQx9WSeyn1e8lVLKK4v5G01t4FtKMzHbpxp0Zp3bxEyA2Ktzl5lkvJgFlY3hLMYfE7BB0QlD29qLnxB39pDzXcbLu8Zdnk3Q60bM76NUCji5Wo7QPCutCMvGzuXMkAsT2MZuIxkPVmQFNcf1IG1N6OTVCBDylrFqxeMhudrfbcIPQMbqgMkOr79vM6L0ow4kqYxxJprKNkwJvurkWLFWwfA1bVQT1b3HC1AQdVtP0q5AHTjxe6TIIVHFvI2yLOFLsD5TtVVqCL2iOBXxvFfEMupQxen7nmxcOs1XRcAmBjxIAgYpB38zSGH16aH785DeweAjcXUuJjZ9sML6sgVBDy5z2laSNydMok9Pk3u4m8B1QAZQzimlh9LJShc2yhtxYDf7DP';
        $manufactureInfoArray = array(
          'Warranty' =>
          array (
            'DisplayValue' => $stringOfLength1023,
            'Label' => 'Warranty',
            'Locale' => 'en_US',
          ),
        );

        $this->assertSame(
            $stringOfLength1023,
            $this->stringOrNullService->getStringOrNull($manufactureInfoArray)
        );

        $stringOfLength1024 = '3t0mzgxlqHRqh5lfh27aN73iNk5Btey8q9iAFl0UDbQhvKgFGattHPbctPH3lqAaIt68QRtbKl8gd8F4bujkinDeSqt8YDfsQNFuHnOdCe1tzCSKbZo6JFqHP0mUiIkt3DiPdpQJPOiY561XPp2Lu7QLiaZ9K645IhzvwEhTEM1FPTg5KJ0oWTxyNuI68b9qNwGB7LwRCLCZnPNpvKu1JhoeyEyiZRB0xiTo9IZq7O26QjjYtbYPCRLzcGWTxaSU1wAREFzYnhuVpvGfyvBi6rhKKNCwcmk8Inb9V3UkEjlTDZF9ixVIrNv8kZnBcC5CSABQViH7mi3z9jsoLgV1r90SRvl4fT5ejtMV2dHxB8RbYoIqtmUEfDBouVeiqx23IraN3OoOGOhnPlcfBmec5bvqiFACTB2sk76Upw0nrLuvCyPkHGlX3TpSZU3okSEqDCJRw8NTereDdltQMVzNPjALE5I46VIJquQD5r8Tg2b2fzFKxTJaxfs7YQ6lGpgSpC1QRlfxYRQLeI0w1QDH6VUa4raBpeULdPFBTOA6z40rbnOTfOfyK8tbXBjSfrCAFCt6l9IB0gm3jLEzNXdSaY6wRXrt80KRFQxEiWaK25x5EJc24OTstBIUjCQpQT7mb2pj9VF9gJitTw58NzETwJt7Xeg2rSGp8I6LIVWOLYJnbSghUdgLwUejP4PmFUfif85zNqDiKloU42ELHCqkwYKBqZTh26q7E0K7annHCBGFQ60GIJgLpn1V9Q5eZt761hc4nCpctcmyYKfLafeVYENvUuJq7OYYMMiucsiLyoWu9gZ2ckQuixeFsf0rxfBoOM6wZ32QSN5xPbbwhhC6IVEhVQJVULEgSSk5fi1o80PrmZGtnTcYfTYkdnSox5k8WuQInxNAw0eDbKcr0T2kt3BpfzqI62RC7C96tZso58iqTxNkfTm4c6iVLyT0gQSkdqMGgGYd1pQQsa6rmFoQEVD7YGpF3i0NVkmU3rqdcEn9KQPj8BplzzI7sdMXthbC';
        $manufactureInfoArray = array(
          'ProductInfo' =>
          array (
            'Warranty' =>
            array (
              'DisplayValue' => $stringOfLength1024,
              'Label' => 'Warranty',
              'Locale' => 'en_US',
            ),
          ),
        );

        $this->assertSame(
            null,
            $this->stringOrNullService->getStringOrNull($manufactureInfoArray)
        );
    }
}
