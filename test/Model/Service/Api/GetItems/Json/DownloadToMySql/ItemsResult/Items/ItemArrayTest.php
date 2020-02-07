<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};
use PHPUnit\Framework\TestCase;

class ItemArrayTest extends TestCase
{
    protected function setUp()
    {
        $this->downloadBrowseNodeInfoArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\BrowseNodeInfo\DownloadArrayToMySql::class
        );
        $this->downloadItemInfoArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\ItemInfo\DownloadArrayToMySql::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->itemArrayService = new AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\ItemArray(
            $this->downloadBrowseNodeInfoArrayToMySqlServiceMock,
            $this->downloadItemInfoArrayToMySqlServiceMock,
            $this->asinTableMock
        );
    }

    public function testDownloadToMySqlWhereItemHasBrowseNodeInfo()
    {
        $this->asinTableMock
            ->expects($this->exactly(1))
            ->method('selectProductIdWhereAsin')
            ->with('B07MMZ2LTB')
            ->will(
                $this->returnValue(
                    ['product_id' => 12345]
                )
            );
        $this->downloadBrowseNodeInfoArrayToMySqlServiceMock
            ->expects($this->exactly(1))
            ->method('downloadArrayToMySql')
            ->with($this->getArrayWhereItemHasBrowseNodeInfo()['BrowseNodeInfo']);

        $this->itemArrayService->downloadToMySql(
            $this->getArrayWhereItemHasBrowseNodeInfo()
        );
    }

    public function testDownloadToMySqlWhereItemDoesNotHaveBrowseNodeInfo()
    {
        $this->asinTableMock
            ->expects($this->exactly(1))
            ->method('selectProductIdWhereAsin')
            ->with('B00B0PIXIK')
            ->will(
                $this->returnValue(
                    ['product_id' => 67890]
                )
            );
        $this->downloadBrowseNodeInfoArrayToMySqlServiceMock
            ->expects($this->exactly(0))
            ->method('downloadArrayToMySql');

        $this->itemArrayService->downloadToMySql(
            $this->getArrayWhereItemDoesNotHaveBrowseNodeInfo()
        );
    }

    protected function getArrayWhereItemHasBrowseNodeInfo(): array
    {
        return array (
          'ASIN' => 'B07MMZ2LTB',
          'BrowseNodeInfo' =>
          array (
            'BrowseNodes' =>
            array (
              0 =>
              array (
                'Ancestor' =>
                array (
                  'ContextFreeName' => 'Electronics',
                  'DisplayName' => 'Electronics',
                  'Id' => '172282',
                ),
                'ContextFreeName' => 'Electronics',
                'DisplayName' => 'Categories',
                'Id' => '493964',
                'IsRoot' => false,
              ),
              1 =>
              array (
                'Ancestor' =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'ContextFreeName' => 'Amazon Devices & Accessories',
                      'DisplayName' => 'Amazon Devices & Accessories',
                      'Id' => '16333372011',
                    ),
                    'ContextFreeName' => 'Categories',
                    'DisplayName' => 'Categories',
                    'Id' => '16333373011',
                  ),
                  'ContextFreeName' => 'Amazon Devices',
                  'DisplayName' => 'Amazon Devices',
                  'Id' => '2102313011',
                ),
                'ContextFreeName' => 'Home Security from Amazon',
                'DisplayName' => 'Home Security from Amazon',
                'Id' => '17386948011',
                'IsRoot' => false,
                'SalesRank' => 7,
              ),
            ),
          ),
          'DetailPageURL' => 'https://www.amazon.com/dp/B07MMZ2LTB?tag=testing-12345-20&linkCode=ogi&th=1&psc=1',
          'Images' =>
          array (
            'Primary' =>
            array (
              'Large' =>
              array (
                'Height' => 500,
                'URL' => 'https://m.media-amazon.com/images/I/31XjoE6OpqL.jpg',
                'Width' => 500,
              ),
              'Medium' =>
              array (
                'Height' => 160,
                'URL' => 'https://m.media-amazon.com/images/I/31XjoE6OpqL._SL160_.jpg',
                'Width' => 160,
              ),
              'Small' =>
              array (
                'Height' => 75,
                'URL' => 'https://m.media-amazon.com/images/I/31XjoE6OpqL._SL75_.jpg',
                'Width' => 75,
              ),
            ),
            'Variants' =>
            array (
              0 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41+-DHZDMnL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41+-DHZDMnL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41+-DHZDMnL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              1 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41hrGysNz8L.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41hrGysNz8L._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41hrGysNz8L._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              2 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiBhHuFjL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiBhHuFjL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiBhHuFjL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              3 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/419+lnbKzXL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/419+lnbKzXL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/419+lnbKzXL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              4 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiUa3l5PL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiUa3l5PL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41PiUa3l5PL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              5 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41y4waL3UDL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41y4waL3UDL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41y4waL3UDL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              6 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/51tPh6w+nCL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/51tPh6w+nCL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/51tPh6w+nCL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              7 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41KxbQVIoML.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41KxbQVIoML._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41KxbQVIoML._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              8 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41L7OyVcW3L.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41L7OyVcW3L._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41L7OyVcW3L._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              9 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41Sob-2irML.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41Sob-2irML._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41Sob-2irML._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              10 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJXgBo8rL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJXgBo8rL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJXgBo8rL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              11 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/4117eIlqN5L.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/4117eIlqN5L._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/4117eIlqN5L._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              12 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/41f3yyWuaXL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/41f3yyWuaXL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/41f3yyWuaXL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              13 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/31wxN54xpLL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/31wxN54xpLL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/31wxN54xpLL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              14 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/31cipVQ6gTL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/31cipVQ6gTL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/31cipVQ6gTL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              15 =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/51P0O2RVhUL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/51P0O2RVhUL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/51P0O2RVhUL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              16 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/41n2C7YgNSL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/41n2C7YgNSL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/41n2C7YgNSL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
              17 =>
              array (
                'Large' =>
                array (
                  'Height' => 286,
                  'URL' => 'https://m.media-amazon.com/images/I/31xcmSfZ6NL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 92,
                  'URL' => 'https://m.media-amazon.com/images/I/31xcmSfZ6NL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 43,
                  'URL' => 'https://m.media-amazon.com/images/I/31xcmSfZ6NL._SL75_.jpg',
                  'Width' => 75,
                ),
              ),
            ),
          ),
          'ItemInfo' =>
          array (
            'ByLineInfo' =>
            array (
              'Brand' =>
              array (
                'DisplayValue' => 'Blink Home Security',
                'Label' => 'Brand',
                'Locale' => 'en_US',
              ),
              'Manufacturer' =>
              array (
                'DisplayValue' => 'Immedia',
                'Label' => 'Manufacturer',
                'Locale' => 'en_US',
              ),
            ),
            'Classifications' =>
            array (
              'Binding' =>
              array (
                'DisplayValue' => 'Electronics',
                'Label' => 'Binding',
                'Locale' => 'en_US',
              ),
              'ProductGroup' =>
              array (
                'DisplayValue' => 'VDO Devices',
                'Label' => 'ProductGroup',
                'Locale' => 'en_US',
              ),
            ),
            'ExternalIds' =>
            array (
              'EANs' =>
              array (
                'DisplayValues' =>
                array (
                  0 => '0841667143910',
                ),
                'Label' => 'EAN',
                'Locale' => 'en_US',
              ),
              'UPCs' =>
              array (
                'DisplayValues' =>
                array (
                  0 => '841667143910',
                ),
                'Label' => 'UPC',
                'Locale' => 'en_US',
              ),
            ),
            'Features' =>
            array (
              'DisplayValues' =>
              array (
                0 => 'Extended battery life – 2 year battery life on two AA lithium batteries with a combination of two-way talk, live view, and motion recording. Double the usage of the XT on a single set of batteries when recording video.',
                1 => '2-way audio – Talk to visitors through the Blink app on your smartphone or tablet.',
                2 => 'Customizable motion detection – Use activity zones to choose where motion is detected so you receive the alerts that matter.',
                3 => 'Free cloud storage – Keep hundreds of clips stored up to a year with no monthly fees or service contract required.',
                4 => 'Works with Alexa – View live streams, motion clips, or arm and disarm your system through select Alexa-enabled devices.',
                5 => 'Day and night coverage – Record and view in up to 1080p HD video during the day and with infrared HD night vision after dark.',
                6 => 'Use indoors/outdoors – Blink XT2 stands up to the elements. Place or mount it inside or outside for whole home security.',
                7 => 'Easy setup – No tools, wiring, or professional installation required.',
              ),
              'Label' => 'Features',
              'Locale' => 'en_US',
            ),
            'ManufactureInfo' =>
            array (
              'ItemPartNumber' =>
              array (
                'DisplayValue' => '53-020304',
                'Label' => 'PartNumber',
                'Locale' => 'en_US',
              ),
              'Model' =>
              array (
                'DisplayValue' => 'BCM00200U',
                'Label' => 'Model',
                'Locale' => 'en_US',
              ),
            ),
            'ProductInfo' =>
            array (
              'Color' =>
              array (
                'DisplayValue' => 'BLACK',
                'Label' => 'Color',
                'Locale' => 'en_US',
              ),
              'IsAdultProduct' =>
              array (
                'DisplayValue' => false,
                'Label' => 'IsAdultProduct',
                'Locale' => 'en_US',
              ),
              'ItemDimensions' =>
              array (
                'Height' =>
                array (
                  'DisplayValue' => 2.8,
                  'Label' => 'Height',
                  'Locale' => 'en_US',
                  'Unit' => 'Inches',
                ),
                'Length' =>
                array (
                  'DisplayValue' => 1.34,
                  'Label' => 'Length',
                  'Locale' => 'en_US',
                  'Unit' => 'Inches',
                ),
                'Weight' =>
                array (
                  'DisplayValue' => 0.19,
                  'Label' => 'Weight',
                  'Locale' => 'en_US',
                  'Unit' => 'Pounds',
                ),
                'Width' =>
                array (
                  'DisplayValue' => 2.8,
                  'Label' => 'Width',
                  'Locale' => 'en_US',
                  'Unit' => 'Inches',
                ),
              ),
              'ReleaseDate' =>
              array (
                'DisplayValue' => '2019-05-22T00:00:01Z',
                'Label' => 'ReleaseDate',
                'Locale' => 'en_US',
              ),
            ),
            'Title' =>
            array (
              'DisplayValue' => 'Blink XT2 Outdoor/Indoor Smart Security Camera with cloud storage included, 2-way audio, 2-year battery life – 1 camera kit',
              'Label' => 'Title',
              'Locale' => 'en_US',
            ),
          ),
          'Offers' =>
          array (
            'Listings' =>
            array (
              0 =>
              array (
                'Availability' =>
                array (
                  'MaxOrderQuantity' => 20,
                  'Message' => 'In Stock.',
                  'MinOrderQuantity' => 1,
                  'Type' => 'Now',
                ),
                'Condition' =>
                array (
                  'SubCondition' =>
                  array (
                    'Value' => 'New',
                  ),
                  'Value' => 'New',
                ),
                'DeliveryInfo' =>
                array (
                  'IsAmazonFulfilled' => true,
                  'IsFreeShippingEligible' => true,
                  'IsPrimeEligible' => true,
                ),
                'Id' => 'OMmZV6%2FICDOFpp4nrCBvYx2gqA0A1%2BuRHWWCvp1fidvjQWZbKdzxKa9csvcSsQV0R3c99aZWH7e7Fb7vm08r51i9PHkObndM2gtEUNYmJ7A%2ByYB0T%2BLQNQ%3D%3D',
                'IsBuyBoxWinner' => true,
                'MerchantInfo' =>
                array (
                  'Id' => 'ATVPDKIKX0DER',
                  'Name' => 'Amazon.com',
                ),
                'Price' =>
                array (
                  'Amount' => 79.989999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$79.99',
                  'Savings' =>
                  array (
                    'Amount' => 20,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$20.00 (20%)',
                    'Percentage' => 20,
                  ),
                ),
                'ProgramEligibility' =>
                array (
                  'IsPrimeExclusive' => false,
                  'IsPrimePantry' => false,
                ),
                'SavingBasis' =>
                array (
                  'Amount' => 99.989999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$99.99',
                ),
                'ViolatesMAP' => false,
              ),
            ),
            'Summaries' =>
            array (
              0 =>
              array (
                'Condition' =>
                array (
                  'Value' => 'New',
                ),
                'HighestPrice' =>
                array (
                  'Amount' => 79.989999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$79.99',
                ),
                'LowestPrice' =>
                array (
                  'Amount' => 79.989999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$79.99',
                ),
                'OfferCount' => 1,
              ),
              1 =>
              array (
                'Condition' =>
                array (
                  'Value' => 'Used',
                ),
                'HighestPrice' =>
                array (
                  'Amount' => 75.549999999999997,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$75.55',
                ),
                'LowestPrice' =>
                array (
                  'Amount' => 69.989999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$69.99',
                ),
                'OfferCount' => 3,
              ),
            ),
          ),
          'ParentASIN' => 'B07N86MCD2',
        );
    }

    protected function getArrayWhereItemDoesNotHaveBrowseNodeInfo()
    {
        return array (
            'ASIN' => 'B00B0PIXIK',
            'DetailPageURL' => 'https://www.amazon.com/dp/B00B0PIXIK?tag=onlinefreestore-20&linkCode=ogi&th=1&psc=1',
        );
    }
}
