<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->saveItemArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql::class
        );
        $this->bannedServiceMock = $this->createMock(
            AmazonService\Product\Banned::class
        );
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->saveArrayToMySqlService = new AmazonService\Api\ResponseElements\Items\SaveArrayToMySql(
            $this->saveItemArrayToMySqlServiceMock,
            $this->bannedServiceMock,
            $this->productTableMock,
            $this->asinTableMock
        );
    }

    public function test_saveArrayToMySql()
    {
        $this->bannedServiceMock
            ->expects($this->exactly(3))
            ->method('isBanned')
            ->withConsecutive(
                ['B009UOMNE8'],
                ['B07MMZ2LTB'],
                ['B07D5J6Z2C']
            )
            ->will(
                $this->onConsecutiveCalls(
                    false,
                    true,
                    false
                )
            );
        $resultMock1 = $this->createMock(Result::class);
        $resultMock1->method('getAffectedRows')->willReturn(1);
        $resultMock2 = $this->createMock(Result::class);
        $resultMock2->method('getAffectedRows')->willReturn(0);
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B009UOMNE8'],
                [1, 'B07D5J6Z2C']
            )
            ->will(
                $this->onConsecutiveCalls(
                    $resultMock1,
                    $resultMock2
                )
            );
        $this->productTableMock
            ->expects($this->exactly(1))
            ->method('insertAsin')
            ->with('B07D5J6Z2C');
        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('saveArrayToMySql')
            ->withConsecutive(
                [$this->getItemsArray()[0]],
                [$this->getItemsArray()[2]]
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getItemsArray()
        );
    }

    protected function getItemsArray(): array
    {
        return array (
          0 =>
          array (
            'ASIN' => 'B009UOMNE8',
            'BrowseNodeInfo' =>
            array (
              'BrowseNodes' =>
              array (
                0 =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'Ancestor' =>
                      array (
                        'ContextFreeName' => 'Arts, Crafts & Sewing',
                        'DisplayName' => 'Arts, Crafts & Sewing',
                        'Id' => '2617941011',
                      ),
                      'ContextFreeName' => 'Categories',
                      'DisplayName' => 'Categories',
                      'Id' => '2617942011',
                    ),
                    'ContextFreeName' => 'Arts, Crafts & Sewing Storage',
                    'DisplayName' => 'Organization, Storage & Transport',
                    'Id' => '2237594011',
                  ),
                  'ContextFreeName' => 'Craft & Sewing Supplies Storage',
                  'DisplayName' => 'Craft & Sewing Supplies Storage',
                  'Id' => '262666011',
                  'IsRoot' => false,
                  'SalesRank' => 1,
                ),
                1 =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'Ancestor' =>
                      array (
                        'ContextFreeName' => 'Arts, Crafts & Sewing',
                        'DisplayName' => 'Arts, Crafts & Sewing',
                        'Id' => '2617941011',
                      ),
                      'ContextFreeName' => 'Categories',
                      'DisplayName' => 'Categories',
                      'Id' => '2617942011',
                    ),
                    'ContextFreeName' => 'Arts, Crafts & Sewing Storage',
                    'DisplayName' => 'Organization, Storage & Transport',
                    'Id' => '2237594011',
                  ),
                  'ContextFreeName' => 'Arts & Crafts Storage Boxes & Organizers',
                  'DisplayName' => 'Storage Boxes & Organizers',
                  'Id' => '8090944011',
                  'IsRoot' => false,
                  'SalesRank' => 1,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B009UOMNE8?tag=testing-12345-20&linkCode=ogi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/61lLQJ5rERL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/61lLQJ5rERL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/61lLQJ5rERL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/61YOl+7Jv1L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/61YOl+7Jv1L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/61YOl+7Jv1L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/619xLNIGikL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/619xLNIGikL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/619xLNIGikL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51wRu6D-nHL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51wRu6D-nHL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51wRu6D-nHL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/412lstuVJFL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/412lstuVJFL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/412lstuVJFL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/4152X1hE4NL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/4152X1hE4NL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/4152X1hE4NL._SL75_.jpg',
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
                  'DisplayValue' => 'Made By Me',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Horizon Group',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Toy',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Toy',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Languages' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 =>
                    array (
                      'DisplayValue' => 'English',
                      'Type' => 'Unknown',
                    ),
                  ),
                  'Label' => 'Language',
                  'Locale' => 'en_US',
                ),
              ),
              'ExternalIds' =>
              array (
                'EANs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '0765940548974',
                    1 => '0793631826759',
                    2 => '0352609524457',
                    3 => '0765940213537',
                    4 => '0352609524464',
                    5 => '0352609524471',
                    6 => '0885416290074',
                    7 => '0787551210743',
                    8 => '0792736366054',
                    9 => '0885737902274',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '352609524464',
                    1 => '885416290074',
                    2 => '787551210743',
                    3 => '793631826759',
                    4 => '352609524471',
                    5 => '765940548974',
                    6 => '765940213537',
                    7 => '885737902274',
                    8 => '792736366054',
                    9 => '352609524457',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Ideal for beginners',
                  1 => 'Easy to follow instructions included',
                  2 => 'Promotes creativity',
                  3 => '165 loops included',
                  4 => 'Create 4 weaving loom projects!',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '765940213537',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '765940213537',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
                'Warranty' =>
                array (
                  'DisplayValue' => 'No Warranty',
                  'Label' => 'Warranty',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
                'Color' =>
                array (
                  'DisplayValue' => 'Purple',
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
                    'DisplayValue' => 2,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 10.5,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 10.5,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2012-10-18T00:00:01Z',
                  'Label' => 'ReleaseDate',
                  'Locale' => 'en_US',
                ),
                'UnitCount' =>
                array (
                  'DisplayValue' => 1,
                  'Label' => 'NumberOfItems',
                  'Locale' => 'en_US',
                ),
              ),
              'Title' =>
              array (
                'DisplayValue' => 'Made By Me Weaving Loom by Horizon Group USA',
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
                    'MaxOrderQuantity' => 3,
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
                  'Id' => 'OMmZV6%2FICDOdSoFc6KhK8%2FLapFeWCEa%2FXBtehE1GR2fIAlP3sm7jNPGAHUE3msDzO8cDLSq%2FL8S6sNbYc95uF0Vusrj0hABtdPJING0ABDf2UaaW9XjSNw%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'Id' => 'ATVPDKIKX0DER',
                    'Name' => 'Amazon.com',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 4,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$4.00',
                    'Savings' =>
                    array (
                      'Amount' => 3.9900000000000002,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$3.99 (50%)',
                      'Percentage' => 50,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 7.9900000000000002,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$7.99',
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
                    'Amount' => 21.649999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$21.65',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 4,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$4.00',
                  ),
                  'OfferCount' => 11,
                ),
              ),
            ),
            'ParentASIN' => 'B07PWHYYMD',
          ),
          1 =>
          array (
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
                    'DisplayValue' => 2.7999999999999998,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 1.3400000000000001,
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
                    'DisplayValue' => 2.7999999999999998,
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
          ),
          2 =>
          array (
            'ASIN' => 'B07D5J6Z2C',
            'BrowseNodeInfo' =>
            array (
              'BrowseNodes' =>
              array (
                0 =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'Ancestor' =>
                      array (
                        'Ancestor' =>
                        array (
                          'Ancestor' =>
                          array (
                            'ContextFreeName' => 'Clothing, Shoes & Jewelry',
                            'DisplayName' => 'Clothing, Shoes & Jewelry',
                            'Id' => '7141123011',
                          ),
                          'ContextFreeName' => 'Clothing, Shoes & Jewelry',
                          'DisplayName' => 'Departments',
                          'Id' => '7141124011',
                        ),
                        'ContextFreeName' => 'Women\'s Fashion',
                        'DisplayName' => 'Women',
                        'Id' => '7147440011',
                      ),
                      'ContextFreeName' => 'Women\'s Clothing',
                      'DisplayName' => 'Clothing',
                      'Id' => '1040660',
                    ),
                    'ContextFreeName' => 'Women\'s Tops, Tees & Blouses',
                    'DisplayName' => 'Tops, Tees & Blouses',
                    'Id' => '2368343011',
                  ),
                  'ContextFreeName' => 'Women\'s Tunics',
                  'DisplayName' => 'Tunics',
                  'Id' => '5418125011',
                  'IsRoot' => false,
                  'SalesRank' => 22,
                ),
                1 =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'Ancestor' =>
                      array (
                        'ContextFreeName' => 'Clothing, Shoes & Jewelry',
                        'DisplayName' => 'Clothing, Shoes & Jewelry',
                        'Id' => '7141123011',
                      ),
                      'ContextFreeName' => 'Clothing, Shoes & Jewelry',
                      'DisplayName' => 'Departments',
                      'Id' => '7141124011',
                    ),
                    'ContextFreeName' => 'Women\'s Fashion',
                    'DisplayName' => 'Women',
                    'Id' => '7147440011',
                  ),
                  'ContextFreeName' => 'Women\'s Shops',
                  'DisplayName' => 'Shops',
                  'Id' => '7581668011',
                  'IsRoot' => false,
                  'SalesRank' => 499,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07D5J6Z2C?tag=testing-12345-20&linkCode=ogi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJCkfqlqL.jpg',
                  'Width' => 385,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJCkfqlqL._SL160_.jpg',
                  'Width' => 123,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/31mJCkfqlqL._SL75_.jpg',
                  'Width' => 58,
                ),
              ),
              'Variants' =>
              array (
                0 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31esobxDZ6L.jpg',
                    'Width' => 385,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31esobxDZ6L._SL160_.jpg',
                    'Width' => 123,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31esobxDZ6L._SL75_.jpg',
                    'Width' => 58,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31MhRrhsg5L.jpg',
                    'Width' => 385,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31MhRrhsg5L._SL160_.jpg',
                    'Width' => 123,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31MhRrhsg5L._SL75_.jpg',
                    'Width' => 58,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31vfBY99wGL.jpg',
                    'Width' => 385,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31vfBY99wGL._SL160_.jpg',
                    'Width' => 123,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31vfBY99wGL._SL75_.jpg',
                    'Width' => 58,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/310bpjW8XcL.jpg',
                    'Width' => 385,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/310bpjW8XcL._SL160_.jpg',
                    'Width' => 123,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/310bpjW8XcL._SL75_.jpg',
                    'Width' => 58,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31KTLG2zogL.jpg',
                    'Width' => 385,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31KTLG2zogL._SL160_.jpg',
                    'Width' => 123,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31KTLG2zogL._SL75_.jpg',
                    'Width' => 58,
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
                  'DisplayValue' => 'Daily Ritual',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Daily Ritual',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Apparel',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Softlines Private Label',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'acd',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
              ),
              'ExternalIds' =>
              array (
                'EANs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '0191770760635',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '191770760635',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Made in Vietnam',
                  1 => 'A perfect match for leggings, this slouchy tee is cut generously with a wide crewneck and a curved drop-tail hem for extra coverage',
                  2 => 'Luxe Jersey - Perfectly rich, smooth fabric that beautifully drapes',
                  3 => 'Start every outfit with Daily Ritual\'s range of elevated basics',
                  4 => 'Model is 5\'11" and wearing a size Small',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'PIRD-1703134-white-Medium',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => 'PIRD-1703134M',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
                'Color' =>
                array (
                  'DisplayValue' => 'White',
                  'Label' => 'Color',
                  'Locale' => 'en_US',
                ),
                'ItemDimensions' =>
                array (
                  'Height' =>
                  array (
                    'DisplayValue' => 1,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 11,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 13,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2018-11-29T00:00:01Z',
                  'Label' => 'ReleaseDate',
                  'Locale' => 'en_US',
                ),
                'Size' =>
                array (
                  'DisplayValue' => 'Medium',
                  'Label' => 'Size',
                  'Locale' => 'en_US',
                ),
              ),
              'Title' =>
              array (
                'DisplayValue' => 'Amazon Brand - Daily Ritual Women\'s Jersey Short-Sleeve Open Crew Neck Tunic, White, Medium',
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
                  'Id' => 'OMmZV6%2FICDOFpp4nrCBvY%2FqmKXD6yFbVWqRQ4qIDSHmAVx3iLElqVmpXaasdn14GLCZOjQG9isWiXDUx%2BOBmJReAmauqhJXiCg45lq08fl2iLaw6AV4HZw%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'Id' => 'ATVPDKIKX0DER',
                    'Name' => 'Amazon.com',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 19.039999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$19.04',
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
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
                    'Amount' => 19.039999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$19.04',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 19.039999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$19.04',
                  ),
                  'OfferCount' => 1,
                ),
              ),
            ),
            'ParentASIN' => 'B076XHFDGZ',
          ),
        );
    }
}
