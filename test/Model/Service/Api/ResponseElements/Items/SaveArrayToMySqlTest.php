<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\ResponseElements\Items;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Test\Hydrator as TestHydrator;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->conditionallySkipItemArrayServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray::class
        );
        $this->saveItemArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql::class
        );
        $this->productTableMock = $this->createMock(
            AmazonTable\Product::class
        );
        $this->asinTableMock = $this->createMock(
            AmazonTable\Product\Asin::class
        );

        $this->saveArrayToMySqlService = new AmazonService\Api\ResponseElements\Items\SaveArrayToMySql(
            $this->conditionallySkipItemArrayServiceMock,
            $this->saveItemArrayToMySqlServiceMock,
            $this->productTableMock,
            $this->asinTableMock
        );
    }

    public function test_saveArrayToMySql_getItemsResult()
    {
        $resultHydrator = new TestHydrator\Result();

        $resultMock1 = $this->createMock(Result::class);
        $resultMock2 = $this->createMock(Result::class);
        $resultMock3 = $this->createMock(Result::class);

        $resultHydrator->hydrate(
            $resultMock1,
            [
                [
                    'product_id' => '12345',
                    'asin' => 'B009UOMNE8',
                    'title' => 'Product title',
                ],
            ]
        );
        $resultHydrator->hydrate(
            $resultMock2,
            [
                [
                    'product_id' => '111',
                    'asin' => 'B07MMZ2LTB',
                    'title' => 'Another roduct title',
                ],
            ]
        );
        $resultHydrator->hydrate(
            $resultMock3,
            [
            ]
        );

        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('selectWhereAsin')
            ->withConsecutive(
                ['B009UOMNE8'],
                ['B07MMZ2LTB'],
                ['B07D5J6Z2C']
            )
            ->will(
                $this->onConsecutiveCalls(
                    $resultMock1,
                    $resultMock2,
                    $resultMock3  // empty result
                )
            );
        $this->asinTableMock
            ->expects($this->exactly(2))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, 'B009UOMNE8'],
                [1, 'B07MMZ2LTB']
            );
        $this->conditionallySkipItemArrayServiceMock
            ->expects($this->exactly(3))
            ->method('shouldArrayBeSkipped')
            ->withConsecutive(
                [$this->getGetItemsArray()[0]],
                [$this->getGetItemsArray()[1]],
                [$this->getGetItemsArray()[2]]
            )
            ->will(
                $this->onConsecutiveCalls(
                    false,
                    true,
                    false
                )
            );
        $this->productTableMock
            ->expects($this->exactly(1))
            ->method('insertAsin')
            ->with('B07D5J6Z2C');
        $this->asinTableMock
            ->expects($this->exactly(3))
            ->method('updateSetModifiedToUtcTimestampWhereAsin')
            ->withConsecutive(
                ['B009UOMNE8'],
                ['B07MMZ2LTB'],
                ['B07D5J6Z2C']
            );
        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(2))
            ->method('saveArrayToMySql')
            ->withConsecutive(
                [$this->getGetItemsArray()[0]],
                [$this->getGetItemsArray()[2]]
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getGetItemsArray()
        );
    }

    public function test_saveArrayToMySql_searchItemsResult()
    {
        $resultMockArray = [
            'product_id' => '12345',
            'asin' => 'B000000000',
            'title' => 'Does not really matter what goes here',
        ];
        $resultHydrator = new TestHydrator\Result();
        $resultMocks = [];
        for ($x = 0; $x <= 9; $x++) {
            $resultMocks[$x] = $this->createMock(Result::class);
            $resultHydrator->hydrate(
                $resultMocks[$x],
                [
                    $resultMockArray
                ]
            );
        }

        $this->asinTableMock
            ->expects($this->exactly(10))
            ->method('selectWhereAsin')
            ->withConsecutive(
                [$this->getSearchItemsArray()[0]['ASIN']],
                [$this->getSearchItemsArray()[1]['ASIN']],
                [$this->getSearchItemsArray()[2]['ASIN']],
                [$this->getSearchItemsArray()[3]['ASIN']],
                [$this->getSearchItemsArray()[4]['ASIN']],
                [$this->getSearchItemsArray()[5]['ASIN']],
                [$this->getSearchItemsArray()[6]['ASIN']],
                [$this->getSearchItemsArray()[7]['ASIN']],
                [$this->getSearchItemsArray()[8]['ASIN']],
                [$this->getSearchItemsArray()[9]['ASIN']]
            )
            ->will(
                $this->onConsecutiveCalls(
                    $resultMocks[0],
                    $resultMocks[1],
                    $resultMocks[2],
                    $resultMocks[3],
                    $resultMocks[4],
                    $resultMocks[5],
                    $resultMocks[6],
                    $resultMocks[7],
                    $resultMocks[8],
                    $resultMocks[9]
                )
            );
        $this->asinTableMock
            ->expects($this->exactly(10))
            ->method('updateSetIsValidWhereAsin')
            ->withConsecutive(
                [1, $this->getSearchItemsArray()[0]['ASIN']],
                [1, $this->getSearchItemsArray()[1]['ASIN']],
                [1, $this->getSearchItemsArray()[2]['ASIN']],
                [1, $this->getSearchItemsArray()[3]['ASIN']],
                [1, $this->getSearchItemsArray()[4]['ASIN']],
                [1, $this->getSearchItemsArray()[5]['ASIN']],
                [1, $this->getSearchItemsArray()[6]['ASIN']],
                [1, $this->getSearchItemsArray()[7]['ASIN']],
                [1, $this->getSearchItemsArray()[8]['ASIN']],
                [1, $this->getSearchItemsArray()[9]['ASIN']]
            );
        $this->asinTableMock
            ->expects($this->exactly(10))
            ->method('updateSetModifiedToUtcTimestampWhereAsin')
            ->withConsecutive(
                [$this->getSearchItemsArray()[0]['ASIN']],
                [$this->getSearchItemsArray()[1]['ASIN']],
                [$this->getSearchItemsArray()[2]['ASIN']],
                [$this->getSearchItemsArray()[3]['ASIN']],
                [$this->getSearchItemsArray()[4]['ASIN']],
                [$this->getSearchItemsArray()[5]['ASIN']],
                [$this->getSearchItemsArray()[6]['ASIN']],
                [$this->getSearchItemsArray()[7]['ASIN']],
                [$this->getSearchItemsArray()[8]['ASIN']],
                [$this->getSearchItemsArray()[9]['ASIN']]
            );

        $this->conditionallySkipItemArrayServiceMock
            ->expects($this->exactly(10))
            ->method('shouldArrayBeSkipped')
            ->withConsecutive(
                [$this->getSearchItemsArray()[0]],
                [$this->getSearchItemsArray()[1]],
                [$this->getSearchItemsArray()[2]],
                [$this->getSearchItemsArray()[3]],
                [$this->getSearchItemsArray()[4]],
                [$this->getSearchItemsArray()[5]],
                [$this->getSearchItemsArray()[6]],
                [$this->getSearchItemsArray()[7]],
                [$this->getSearchItemsArray()[8]],
                [$this->getSearchItemsArray()[9]]
            )
            ->will(
                $this->onConsecutiveCalls(
                    false,
                    true,
                    false,
                    false,
                    false,
                    false,
                    false,
                    false,
                    false,
                    true
                )
            );
        $this->productTableMock
            ->expects($this->exactly(0))
            ->method('insertAsin');
        $this->saveItemArrayToMySqlServiceMock
            ->expects($this->exactly(8))
            ->method('saveArrayToMySql')
            ->withConsecutive(
                [$this->getSearchItemsArray()[0]],
                [$this->getSearchItemsArray()[2]],
                [$this->getSearchItemsArray()[3]],
                [$this->getSearchItemsArray()[4]],
                [$this->getSearchItemsArray()[5]],
                [$this->getSearchItemsArray()[6]],
                [$this->getSearchItemsArray()[7]],
                [$this->getSearchItemsArray()[8]]
            );

        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSearchItemsArray()
        );
    }

    protected function getGetItemsArray(): array
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

    protected function getSearchItemsArray(): array
    {
        return array (
          0 =>
          array (
            'ASIN' => 'B07XQXZXJC',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 1,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07XQXZXJC?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41jiSVJ-ZDL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41jiSVJ-ZDL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41jiSVJ-ZDL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/416k2s3bxGL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/416k2s3bxGL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/416k2s3bxGL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41YWyBibC4L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41YWyBibC4L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41YWyBibC4L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41q-YW6QobL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41q-YW6QobL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41q-YW6QobL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31OORCM3E8L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31OORCM3E8L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31OORCM3E8L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ao+Kl7PlL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ao+Kl7PlL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ao+Kl7PlL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51G8+CbSb-L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51G8+CbSb-L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51G8+CbSb-L._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'S 1TB All-Digital Edition -(Disc-free Gaming)',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842528992',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842528992',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Go all digital with the Xbox One S all digital edition and enjoy disc free gaming',
                  1 => 'If purchased through Xbox all access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer. Plus console upgrade option',
                  2 => 'Bundle includes: Xbox One S 1TB All-digital edition console (Disc-free gaming), wireless controller, 1-month of Xbox live gold, and download codes for Minecraft, Sea of thieves and Fortnite Battle Royale',
                  3 => 'Fortnite Battle Royale content includes 2000 V-Bucks, Legendary Rogue Spider Knight Outfit, and 2 Style Variants that unlock as in-game challenges are completed in free Fortnite Battle Royale and Creative Modes only save the world campaign not included Xbox live gold required to play Fortnite Battle Royale, Sea of Thieves, and multiplayer in minecraft (subscription sold separately)',
                  4 => 'Pick up where you left off on another Xbox One or Windows 10 PC with Xbox Play anywhere titles like sea of thieves',
                  5 => 'Your games and saves travel with you: Just sign in on any Xbox One with your Microsoft Account and you’re ready to go',
                  6 => 'Does not play physical discs: Games are downloaded and ready to play when you are; no need to worry about discs; See bottom of page for important information',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'NJP-00050',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => 'NJP-00050',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
                'Warranty' =>
                array (
                  'DisplayValue' => 'Limited Warranty',
                  'Label' => 'Warranty',
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
                    'DisplayValue' => 12.9,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 2.6000000000000001,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 8.9299999999999997,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 13.199999999999999,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-09-24T00:00:01Z',
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
                'DisplayValue' => 'Xbox One S 1TB All-Digital Edition Console (Disc-Free Gaming)',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 81.629999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$81.63',
                ),
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
                    'Message' => 'In stock on March 28, 2020. Order it now.',
                    'MinOrderQuantity' => 1,
                    'Type' => 'Backorderable',
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDVIWLvM6FsUMwfKY1osov80uSDfFhPg%2BhZKPvRA0HLfrVi8lI5aWj6sXbVMLAhygw6I3FqerphFse2BOxXqyZfT1SHZCDCq1PM7cnOCIL659o8Ttii0By7p%2B%2BVckDUZxoMU6zvbtmdEB',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A1NZ3M0XYXYPFO',
                    'Name' => 'itreplay',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 170.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$170.99',
                    'Savings' =>
                    array (
                      'Amount' => 79,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$79.00 (32%)',
                      'Percentage' => 32,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 249.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$249.99',
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
                    'Amount' => 333,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$333.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 170.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$170.99',
                  ),
                  'OfferCount' => 108,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 224.97,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$224.97',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 131.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$131.99',
                  ),
                  'OfferCount' => 17,
                ),
                2 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Collectible',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 269.98000000000002,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$269.98',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 269.98000000000002,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$269.98',
                  ),
                  'OfferCount' => 1,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          1 =>
          array (
            'ASIN' => 'B074JF7M9X',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 2,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 262,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B074JF7M9X?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/412jZOFrVPL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/412jZOFrVPL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/412jZOFrVPL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/31N6Ub47N4L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31N6Ub47N4L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31N6Ub47N4L._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
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
                    0 => '0889842009477',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842009477',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Xbox One S 1TB console I Two Xbox Wireless controller I 1-month trial of Xbox Game Pass I 14-day trial of Xbox Live Gold',
                  1 => 'Xbox Game Pass 1-month trial included: Get 1 months of Xbox Game Pass. Play Sea of Thieves, State of Decay 2, and Crackdown 3 with Xbox Game Pass the day they’re released, and over 100 more great games, for one low monthly price. Includes: 14-day Xbox Live Gold Trial - connect and play with friends and family on Xbox Live, the most advanced multiplayer network',
                  2 => 'Spatial Audio Bring your games and movies to life with immersive audio through Dolby Atmos and DTS: X; Endless entertainment apps,Enjoy your favorite apps like YouTube, Spotify, HBO NOW, ESPN and many more.',
                  3 => 'Watch 4K Blu-ray movies and stream 4K video on Netflix, Amazon, Hulu, and more and experience richer, more luminous colors in games and video with High Dynamic Range technology.',
                  4 => 'Connect and play with friends and family on Xbox Live, the fastest, most reliable gaming network,Play Minecraft with friends who are on Windows 10, mobile, and console',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'OEM',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
                'ItemDimensions' =>
                array (
                  'Height' =>
                  array (
                    'DisplayValue' => 17,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 4.5,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 8.9000000000000004,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 11.4,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
              ),
              'Title' =>
              array (
                'DisplayValue' => 'Xbox One S Two Controller Bundle (1TB) Includes Xbox One S, 2 Wireless Controllers, 1-Month Game Pass Trial, 14-day Xbox Live Gold Trial',
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDSupMYqju5LTPgeGa%2FnCj4W9MjVqhaM%2Byn1ZZYCqPGfQHCxMmiLZmVKnRdWwf0V1lEFwz2NO0ETiZ3ewcWWQXfZGfgsY1J9Pxc%2BypHePO1mZttweA7qfpCFK5bVqZz3njQ%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A26DJC1IPLUBUB',
                    'Name' => 'Kailone Tech',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 269.94999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$269.95',
                    'Savings' =>
                    array (
                      'Amount' => 80.040000000000006,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$80.04 (23%)',
                      'Percentage' => 23,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 349.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$349.99',
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
                    'Amount' => 383.05000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$383.05',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 268.85000000000002,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$268.85',
                  ),
                  'OfferCount' => 60,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 259,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$259.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 248.88999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$248.89',
                  ),
                  'OfferCount' => 2,
                ),
              ),
            ),
          ),
          2 =>
          array (
            'ASIN' => 'B07VMMNDCJ',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 6,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07VMMNDCJ?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41rQPv+xRuL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41rQPv+xRuL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41rQPv+xRuL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/31bMjnzwrPL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31bMjnzwrPL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31bMjnzwrPL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51kzKFEiyeL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51kzKFEiyeL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51kzKFEiyeL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41UHqzmLxaL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41UHqzmLxaL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41UHqzmLxaL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51H-w84C6kL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51H-w84C6kL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51H-w84C6kL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51XHdsS8jAL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51XHdsS8jAL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51XHdsS8jAL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51ONwQBZs4L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51ONwQBZs4L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51ONwQBZs4L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51G80unLH+L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51G80unLH+L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51G80unLH+L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                7 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                8 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31qRsHwlYIL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31qRsHwlYIL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31qRsHwlYIL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                9 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/512Ktra-jSL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/512Ktra-jSL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/512Ktra-jSL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                10 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51pYe0afH9L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51pYe0afH9L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51pYe0afH9L._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'S 1TB - Gears 5 Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842479232',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842479232',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: Xbox One S 1TB Console; Xbox wireless Controller; Full-game download of Gears 5; Full-game downloads of Gears of War: Ultimate Edition and Gears of War 2, 3, and 4; A 1-month Xbox Game Pass trial, and 1-month of Xbox Live Gold',
                  1 => 'If purchased through Xbox All Access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer. Plus console upgrade option',
                  2 => 'Campaign: Follow kait diaz on a journey to discover her family connection to the enemy and the true danger to sera - herself',
                  3 => 'Escape: Outrun the Bomb, outsmart the Swarm, Escape the hive',
                  4 => 'Versus: 11 game modes, new maps and rewards for everyone',
                  5 => 'Horde: Conquer the horde by building defenses, collecting power, leveling up your skills and working as a team',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '234-01202',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '234-01020',
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
                    'DisplayValue' => 2,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 10.57,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 3,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-09-10T00:00:01Z',
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
                'DisplayValue' => 'Xbox One S 1TB Console - Gears 5 Bundle',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 99.620000000000005,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$99.62',
                ),
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
                    'IsAmazonFulfilled' => false,
                    'IsFreeShippingEligible' => false,
                    'IsPrimeEligible' => false,
                  ),
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDXXiTDgafjkt3pKC%2FitxT8M02Fi%2BCvQ09ithG7dxqTBeLOgikQl82aejAf3vj9DCpThYyUtpIIg6b9nD3Yhx4xR%2FIRBLa9VnKda1lt5om3xX5UBW7UOsAPb1oO%2B5f334Ag%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A2YLYLTN75J8LR',
                    'Name' => 'antonline',
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'ViolatesMAP' => true,
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
                  'OfferCount' => 45,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'OfferCount' => 13,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          3 =>
          array (
            'ASIN' => 'B07YD67145',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 4,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 278,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07YD67145?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41GNr6i5rFL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41GNr6i5rFL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41GNr6i5rFL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/417D4YInQ1L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/417D4YInQ1L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/417D4YInQ1L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31pVembF4EL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31pVembF4EL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31pVembF4EL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31m1GXpKjJL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                7 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'S 1TB - Star Wars Jedi: Fallen Order Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
                'Languages' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 =>
                    array (
                      'DisplayValue' => 'English',
                      'Type' => 'Unknown',
                    ),
                    1 =>
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
                    0 => '0889842485035',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842485035',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: Xbox One S 1TB console, Xbox Wireless Controller, full-game download of Star Wars Jedi: Fallen Order Deluxe Edition, 1-Month of Xbox Live Gold, a 1-Month trial of Xbox Game Pass for Console, and 1-Month of EA Access',
                  1 => 'If purchased through Xbox All Access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer. Plus console upgrade option',
                  2 => 'Get the story behind the game with the Star Wars Jedi: Fallen Order Deluxe Edition, including a cosmetic skin for BD-1, a cosmetic skin for the Stinger Mantis, a Digital Art Book, and a “Director’s Cut” featuring behind-the-scenes videos containing over 90 minutes of footage from the making of the game',
                  3 => 'Experience iconic and familiar planets, weapons, gear, and enemies while meeting a roster of fresh characters, locations, creatures, droids, and adversaries new to Star Wars on a galaxy-spanning adventure',
                  4 => 'Develop your connection to the force and tap into powerful Force abilities for exploration and combat Master the iconic lightsaber in thoughtful and innovative combat',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '234-01089',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '234-01089',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
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
                    'DisplayValue' => 12.9,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 2.6000000000000001,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 10.58,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 13.199999999999999,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-11-15T00:00:01Z',
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
                'DisplayValue' => 'Xbox One S 1TB Console - Star Wars Jedi: Fallen Order Bundle',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 77.140000000000001,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$77.14',
                ),
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
                    'IsAmazonFulfilled' => false,
                    'IsFreeShippingEligible' => false,
                    'IsPrimeEligible' => false,
                  ),
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDSun0rQU4POQlfPf2lJzk9r0GuskrRjatrcMDAy2qWjRcBh9exGchFJj19w6wi7Yeh2LifOJJUqEYCDrB67qOU1eCQp8BCms3mUNPKHoOSv1y2gvbAUPVZyhBtlWgrdiD64hYdroRsK7',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A3H89ADJHTH9SN',
                    'Name' => 'WorldWide Distributors',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 246.97999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$246.98',
                    'Savings' =>
                    array (
                      'Amount' => 53.009999999999998,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$53.01 (18%)',
                      'Percentage' => 18,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 299.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$299.99',
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
                    'Amount' => 441.58999999999997,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$441.59',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 189,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$189.00',
                  ),
                  'OfferCount' => 66,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 229.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$229.99',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 173.58000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$173.58',
                  ),
                  'OfferCount' => 5,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          4 =>
          array (
            'ASIN' => 'B07YD5ZBTW',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 3,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07YD5ZBTW?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41Xh6knZBEL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41Xh6knZBEL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41Xh6knZBEL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/41lmQqE8oeL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41lmQqE8oeL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41lmQqE8oeL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31D57HLDaXL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31D57HLDaXL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31D57HLDaXL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 281,
                    'URL' => 'https://m.media-amazon.com/images/I/31gakllXPmL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 90,
                    'URL' => 'https://m.media-amazon.com/images/I/31gakllXPmL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 42,
                    'URL' => 'https://m.media-amazon.com/images/I/31gakllXPmL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 185,
                    'URL' => 'https://m.media-amazon.com/images/I/21qb-vbUSdL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 59,
                    'URL' => 'https://m.media-amazon.com/images/I/21qb-vbUSdL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 28,
                    'URL' => 'https://m.media-amazon.com/images/I/21qb-vbUSdL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31efmnVZAbL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41xaGTVSI3L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41YS9zaxzGL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                7 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41RK7WO2wEL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                8 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41zu3b6JEBL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'X 1TB - Star Wars Jedi: Fallen Order Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842485257',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842485257',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: Xbox 1 X 1TB console, Xbox wireless controller, fullgame download of star wars jedi: Fallen order deluxe edition, 1 month of Xbox live gold, a 1month trial of Xbox game pass for console, and 1month of EA access',
                  1 => 'If purchased through Xbox All Access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer; Plus console upgrade option',
                  2 => 'Get the story behind the game with the star wars Jedi: Fallen order Deluxe Edition, including a cosmetic skin for BD1, a cosmetic skin for the stinger mantis, a digital art book, and a “Director’s Cut” featuring behindthescenes videos containing over 90 minutes of footage from the making of the game',
                  3 => 'Experience iconic and familiar planets, weapons, gear, and enemies while meeting a roster of fresh characters, locations, creatures, droids, and adversaries new to Star Wars on a galaxyspanning adventure',
                  4 => 'Enjoy instant access to over 100 high quality games out of the box with the included 1 month trial of Xbox game pass for console',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'CYV-00411',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => 'CYV-00411',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
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
                    'DisplayValue' => 12,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 19,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 12.470000000000001,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 5,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-11-15T00:00:01Z',
                  'Label' => 'ReleaseDate',
                  'Locale' => 'en_US',
                ),
              ),
              'Title' =>
              array (
                'DisplayValue' => 'Xbox One X 1TB Console - Star Wars Jedi: Fallen Order Bundle',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 145.06999999999999,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$145.07',
                ),
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
                    'IsAmazonFulfilled' => false,
                    'IsFreeShippingEligible' => false,
                    'IsPrimeEligible' => false,
                  ),
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDWTvhAgYDb%2Fmqp61kzRiNFsF%2BpVjV3wmVGX%2Fs764IDIT376umisCsnI%2BICXEllRZEtzFMdw9IA4eEC%2BMV8fjlY9xHB6ni6PmWCEgaL59hqLI%2BsbxdsPEmuMDBOIXN4y0Zg%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A2YLYLTN75J8LR',
                    'Name' => 'antonline',
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'ViolatesMAP' => true,
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
                  'OfferCount' => 80,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'OfferCount' => 41,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          5 =>
          array (
            'ASIN' => 'B07P19XP84',
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
                          'ContextFreeName' => 'Video Games',
                          'DisplayName' => 'Video Games',
                          'Id' => '468642',
                        ),
                        'ContextFreeName' => 'Videogames',
                        'DisplayName' => 'Categories',
                        'Id' => '11846801',
                      ),
                      'ContextFreeName' => 'Legacy Systems',
                      'DisplayName' => 'Legacy Systems',
                      'Id' => '294940',
                    ),
                    'ContextFreeName' => 'Xbox Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox',
                    'Id' => '537504',
                  ),
                  'ContextFreeName' => 'Xbox Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '720022',
                  'IsRoot' => false,
                  'SalesRank' => 1,
                ),
                1 =>
                array (
                  'Ancestor' =>
                  array (
                    'Ancestor' =>
                    array (
                      'ContextFreeName' => 'Video Games',
                      'DisplayName' => 'Video Games',
                      'Id' => '468642',
                    ),
                    'ContextFreeName' => 'Videogames',
                    'DisplayName' => 'Categories',
                    'Id' => '11846801',
                  ),
                  'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                  'DisplayName' => 'Xbox One',
                  'Id' => '6469269011',
                  'IsRoot' => false,
                  'SalesRank' => 59,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 219,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07P19XP84?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Contributors' =>
                array (
                  0 =>
                  array (
                    'Locale' => 'en_US',
                    'Name' => 'Microsoft',
                    'Role' => 'Designer',
                    'RoleType' => 'designer',
                  ),
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: Xbox One S 1TB Console, 1 Xbox Wireless Controller (with 3.5mm headset jack), HDMI cable (4K Capable), AC Power cable',
                  1 => 'With Xbox One S, watch 4k Blu-ray Movies, stream 4K content on Amazon, Netflix, Hulu and Microsoft Movies apps',
                  2 => 'Stream 4K content on Netflix and Amazon video, and watch Ultra HD (UHD) Blu-ray movies in stunning visual fidelity with High Dynamic Range.',
                  3 => 'Play over 100 console exclusives and a growing library of Xbox 360 games on Xbox One',
                  4 => 'Get access to a world of instant entertainment with this product. Just connect to the Internet and stream movies, listen to music, and access a wide variety of other content.',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'B07P19XP84',
                  'Label' => 'PartNumber',
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
                    'DisplayValue' => 5,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 15,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 9,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 10,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
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
                'DisplayValue' => 'Microsoft Xbox One S 1TB Console with Xbox One Wireless Controller - Robot White',
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDYd6WKVf8dJ6f1CmDwEkOEs6dtyLOPq4D72C0W5YiTheKPEMzyuZaLGpfKT3Ga6j2kWS3hiE0u228YZ3pJzNMQJExHkilM9uGMiQceuwoTnQg49Loe8o83JV%2BcDNFTCdmQIkRXw9TGqD',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A5W45QDYAHWB2',
                    'Name' => 'Direct Distributor',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 231.75,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$231.75',
                    'Savings' =>
                    array (
                      'Amount' => 18.239999999999998,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$18.24 (7%)',
                      'Percentage' => 7,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 249.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$249.99',
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
                    'Amount' => 299.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$299.99',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 226.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$226.99',
                  ),
                  'OfferCount' => 13,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 285,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$285.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 189,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$189.00',
                  ),
                  'OfferCount' => 5,
                ),
              ),
            ),
          ),
          6 =>
          array (
            'ASIN' => 'B07VFY91HM',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 5,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 319,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07VFY91HM?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41uJnnEKMHL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41uJnnEKMHL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41uJnnEKMHL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/41tl3Tn84BL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41tl3Tn84BL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41tl3Tn84BL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51aWc658aXL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51aWc658aXL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51aWc658aXL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31C44mO2S8L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31C44mO2S8L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31C44mO2S8L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51-uWU9h-nL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51-uWU9h-nL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51-uWU9h-nL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41pxi4JwXaL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41pxi4JwXaL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41pxi4JwXaL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41cjoYnXCQL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41cjoYnXCQL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41cjoYnXCQL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51gdaKwO3WL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51gdaKwO3WL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51gdaKwO3WL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                7 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41-20rAKzfL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41-20rAKzfL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41-20rAKzfL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                8 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/417GOOJ4RdL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/417GOOJ4RdL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/417GOOJ4RdL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'S 1TB - NBA 2K20 Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842478792',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842478792',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: 1TB Xbox One S Console, Xbox wireless Controller, full-game download of NBA 2K20, a month Xbox Live Gold subscription, and a month Xbox Game Pass trial',
                  1 => 'If purchased through Xbox All Access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer. Plus console upgrade option',
                  2 => 'Redefine what\'s possible in sports gaming with unparalleled player control and customization Experience best-in-class graphics and gameplay across several groundbreaking game modes',
                  3 => 'Join the open-world Neighborhood and shoot hoops with the best ballers from around the world Create what\'s next in basketball culture in the series where gamers and ballers come together',
                  4 => 'Enjoy instant access to over 100 high-quality games out of the box with the included one-month trial of Xbox Game Pass',
                  5 => 'Watch 4K Blu-ray movies; stream 4K video on Netflix, Amazon, and YouTube, among others; and listen to music with Spotify',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '234-00998',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '234-00998',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
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
                    'DisplayValue' => 1,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 2,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 10.56,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 2,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-09-06T00:00:01Z',
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
                'DisplayValue' => 'Xbox One S 1TB Console - NBA 2K20 Bundle - [DISCONTINUED]',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 127.75,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$127.75',
                ),
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
                    'IsAmazonFulfilled' => false,
                    'IsFreeShippingEligible' => false,
                    'IsPrimeEligible' => false,
                  ),
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDV%2BZf7ttSz1B%2Fn5t1KqbDTFPwTbvbctCv4vy6X348f0SwpvvB4EiIZ5tNIPM8stU5jEWSY7EqssxTdTjSo1vX4cNsqLXpJPn696xDhhp4KWZN2%2BiHc4KRN7nO64XRmCO5LSqQk7uxCe7',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A3H89ADJHTH9SN',
                    'Name' => 'WorldWide Distributors',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 239.97999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$239.98',
                    'Savings' =>
                    array (
                      'Amount' => 60.009999999999998,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$60.01 (20%)',
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
                    'Amount' => 299.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$299.99',
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
                    'Amount' => 399.94999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$399.95',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 228,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$228.00',
                  ),
                  'OfferCount' => 45,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 299.49000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$299.49',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 198.87,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$198.87',
                  ),
                  'OfferCount' => 6,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          7 =>
          array (
            'ASIN' => 'B07VLH5JR7',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 19,
                ),
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07VLH5JR7?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41FSKqccZwL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41FSKqccZwL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41FSKqccZwL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/51+fTvaZjcL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51+fTvaZjcL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51+fTvaZjcL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41QdVfxT2OL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41QdVfxT2OL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41QdVfxT2OL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41i-a0Wq31L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41i-a0Wq31L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41i-a0Wq31L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31uC1FnWkqL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31uC1FnWkqL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31uC1FnWkqL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41xhp1JiVML.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41xhp1JiVML._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41xhp1JiVML._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51usr2gqL5L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51usr2gqL5L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51usr2gqL5L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41KJI6DqwZL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41KJI6DqwZL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41KJI6DqwZL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                7 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41ZcR59IjwL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41ZcR59IjwL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41ZcR59IjwL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                8 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41sjju50MoL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41sjju50MoL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41sjju50MoL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                9 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51OKHEt07iL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51OKHEt07iL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51OKHEt07iL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                10 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51e1yNOCA-L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51e1yNOCA-L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51e1yNOCA-L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                11 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/518XsEmAS1L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/518XsEmAS1L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/518XsEmAS1L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                12 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51E2g91-+qL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51E2g91-+qL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51E2g91-+qL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'X 1TB - Gears 5 Limited Edition Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842477733',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842477733',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: XB1 x 1TB limited edition console; Xbox wl controller kait diaz le; Full game download of Gears 5 ultimate edition; Full game downloads of gears of war: ue & gears of war 2, 3, &4; Month trial of Xbox game pass;& month of Xbox live gold',
                  1 => 'If purchased through Xbox All Access: Enjoy low monthly payments for 24 months, no upfront cost, access to over 100 high-quality games and online multiplayer. Plus console upgrade option',
                  2 => 'Own this limited edition console featuring a dark translucent casing that makes the Crimson Omen appear submerged in snow and ice, designed by gears co creator rod fergusson and the Xbox team',
                  3 => 'Bring the gears universe to life: Laser etched cracks appear across the console\'s icy top surface and snow drifts across a golden locust symbol on the back',
                  4 => 'Immerse yourself in campaign following kait diaz on a journey to discover her family connection to the enemy and the true danger to sera herself',
                  5 => 'Continue the challenge with additional brutal, action packed game modes including escape, versus, and horde',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => 'FMP-00130',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => 'FMP-00130',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
                'Color' =>
                array (
                  'DisplayValue' => 'Black',
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
                  'Weight' =>
                  array (
                    'DisplayValue' => 12.619999999999999,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2019-09-06T00:00:01Z',
                  'Label' => 'ReleaseDate',
                  'Locale' => 'en_US',
                ),
              ),
              'Title' =>
              array (
                'DisplayValue' => 'Xbox One X 1Tb Console - Gears 5 Limited Edition Bundle',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 207.47999999999999,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$207.48',
                ),
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDQm1QXUl1TIXn48F3EFb94d442OfLPQU3aNt7aQwHfvEg5gk4waQGdlM68DCv4232Yod%2FAkFwDZ4QzwjT%2FCA7ebEKYxUAD9pn7siduESuNZm0FdTqrEQNnFmK0KEuflWKXarwp4kZm8R',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A2AWKZBCPMNLY2',
                    'Name' => 'HALF TIME',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 389,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$389.00',
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
                    'Amount' => 599,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$599.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 380,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$380.00',
                  ),
                  'OfferCount' => 41,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 385,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$385.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 320.23000000000002,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$320.23',
                  ),
                  'OfferCount' => 9,
                ),
                2 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Collectible',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 369.88999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$369.89',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 369.88999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$369.89',
                  ),
                  'OfferCount' => 1,
                ),
              ),
            ),
            'ParentASIN' => 'B01GY35T4S',
          ),
          8 =>
          array (
            'ASIN' => 'B073858Q9X',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 7,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 740,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B073858Q9X?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/41wNqTxUoGL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41UAkYT-ozL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31HhN6B+VrL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31DkP+ZnKxL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41TCtHJ-esL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
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
                    0 => '0889842105001',
                    1 => '6006593947054',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842105001',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Watch 4K Blue ray movies and stream 4K content on Netflix and Amazon video',
                  1 => 'Experience richer, more luminous colors in games and video with high dynamic range',
                  2 => 'Play over 100 console exclusives and a growing library of Xbox 360 games on Xbox One',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '234-00347',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '234-00347',
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
                    'DisplayValue' => 1,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 12,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 2,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2017-06-01T00:00:01Z',
                  'Label' => 'ReleaseDate',
                  'Locale' => 'en_US',
                ),
                'Size' =>
                array (
                  'DisplayValue' => '1 TB',
                  'Label' => 'Size',
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
                'DisplayValue' => 'Microsoft Xbox One S 1Tb Console - White [Discontinued]',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 88.420000000000002,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$88.42',
                ),
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDYmbTLQRIrr0Bzrg6hWQ3K44ej8QXGHKxAtMUbc91WURCIjZsGF%2Fp0S40Pm%2Fg0xsEjSIXQCPSVqq2UajLciX8yTVZEWDmgsIkl3rCtW0EVPgeOa0qX4YhEgBhCd93xwpalOnwvPuxYpY',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'DefaultShippingCountry' => 'US',
                    'Id' => 'A5W45QDYAHWB2',
                    'Name' => 'Direct Distributor',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 228.72,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$228.72',
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
                    'Amount' => 399,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$399.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 219.94999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$219.95',
                  ),
                  'OfferCount' => 22,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 293,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$293.00',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 169.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$169.99',
                  ),
                  'OfferCount' => 12,
                ),
              ),
            ),
            'ParentASIN' => 'B07WS71MLV',
          ),
          9 =>
          array (
            'ASIN' => 'B07GB1D7PF',
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
                        'ContextFreeName' => 'Video Games',
                        'DisplayName' => 'Video Games',
                        'Id' => '468642',
                      ),
                      'ContextFreeName' => 'Videogames',
                      'DisplayName' => 'Categories',
                      'Id' => '11846801',
                    ),
                    'ContextFreeName' => 'Xbox One Games, Consoles & Accessories',
                    'DisplayName' => 'Xbox One',
                    'Id' => '6469269011',
                  ),
                  'ContextFreeName' => 'Xbox One Consoles',
                  'DisplayName' => 'Consoles',
                  'Id' => '6469295011',
                  'IsRoot' => false,
                  'SalesRank' => 17,
                ),
              ),
              'WebsiteSalesRank' =>
              array (
                'ContextFreeName' => 'Video Games',
                'DisplayName' => 'Video Games',
                'SalesRank' => 1831,
              ),
            ),
            'DetailPageURL' => 'https://www.amazon.com/dp/B07GB1D7PF?tag=associate-tag-20&linkCode=osi&th=1&psc=1',
            'Images' =>
            array (
              'Primary' =>
              array (
                'Large' =>
                array (
                  'Height' => 500,
                  'URL' => 'https://m.media-amazon.com/images/I/51vdwUJdpGL.jpg',
                  'Width' => 500,
                ),
                'Medium' =>
                array (
                  'Height' => 160,
                  'URL' => 'https://m.media-amazon.com/images/I/51vdwUJdpGL._SL160_.jpg',
                  'Width' => 160,
                ),
                'Small' =>
                array (
                  'Height' => 75,
                  'URL' => 'https://m.media-amazon.com/images/I/51vdwUJdpGL._SL75_.jpg',
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
                    'URL' => 'https://m.media-amazon.com/images/I/413NtrV9PDL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/413NtrV9PDL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/413NtrV9PDL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                1 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/41J3P9JmzZL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/41J3P9JmzZL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/41J3P9JmzZL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                2 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/51+pa3IZ6qL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/51+pa3IZ6qL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/51+pa3IZ6qL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                3 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/312cE-RiV1L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/312cE-RiV1L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/312cE-RiV1L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                4 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31nStcEyo+L.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31nStcEyo+L._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31nStcEyo+L._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                5 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31XJKePvjuL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31XJKePvjuL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31XJKePvjuL._SL75_.jpg',
                    'Width' => 75,
                  ),
                ),
                6 =>
                array (
                  'Large' =>
                  array (
                    'Height' => 500,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ky9tHuJJL.jpg',
                    'Width' => 500,
                  ),
                  'Medium' =>
                  array (
                    'Height' => 160,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ky9tHuJJL._SL160_.jpg',
                    'Width' => 160,
                  ),
                  'Small' =>
                  array (
                    'Height' => 75,
                    'URL' => 'https://m.media-amazon.com/images/I/31Ky9tHuJJL._SL75_.jpg',
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
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Brand',
                  'Locale' => 'en_US',
                ),
                'Manufacturer' =>
                array (
                  'DisplayValue' => 'Microsoft',
                  'Label' => 'Manufacturer',
                  'Locale' => 'en_US',
                ),
              ),
              'Classifications' =>
              array (
                'Binding' =>
                array (
                  'DisplayValue' => 'Video Game',
                  'Label' => 'Binding',
                  'Locale' => 'en_US',
                ),
                'ProductGroup' =>
                array (
                  'DisplayValue' => 'Video Games',
                  'Label' => 'ProductGroup',
                  'Locale' => 'en_US',
                ),
              ),
              'ContentInfo' =>
              array (
                'Edition' =>
                array (
                  'DisplayValue' => 'S 1TB - NBA 2K19 Bundle',
                  'Label' => 'Edition',
                  'Locale' => 'en_US',
                ),
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
                    0 => '0889842307276',
                  ),
                  'Label' => 'EAN',
                  'Locale' => 'en_US',
                ),
                'UPCs' =>
                array (
                  'DisplayValues' =>
                  array (
                    0 => '889842307276',
                  ),
                  'Label' => 'UPC',
                  'Locale' => 'en_US',
                ),
              ),
              'Features' =>
              array (
                'DisplayValues' =>
                array (
                  0 => 'Bundle includes: Xbox One S (1TB), wireless controller, full game download of NBA 2K19, 1 month Xbox Game Pass trial, 14 day Xbox Live Gold trial',
                  1 => 'Celebrate 20 years of redefining sports gaming with the #1 rated NBA video game simulation series',
                  2 => 'Take on the best NBA 2K19 players in the world on Xbox Live, the fastest, most reliable gaming network',
                  3 => 'Enjoy instant access to over 100 games out of the box with the included one month trial of Xbox Game Pass',
                  4 => 'Watch 4K Blu ray movies; stream 4K video on Netflix, and YouTube, among others; and listen to music with Spotify',
                ),
                'Label' => 'Features',
                'Locale' => 'en_US',
              ),
              'ManufactureInfo' =>
              array (
                'ItemPartNumber' =>
                array (
                  'DisplayValue' => '234-00575',
                  'Label' => 'PartNumber',
                  'Locale' => 'en_US',
                ),
                'Model' =>
                array (
                  'DisplayValue' => '234-00575',
                  'Label' => 'Model',
                  'Locale' => 'en_US',
                ),
                'Warranty' =>
                array (
                  'DisplayValue' => '1',
                  'Label' => 'Warranty',
                  'Locale' => 'en_US',
                ),
              ),
              'ProductInfo' =>
              array (
                'Color' =>
                array (
                  'DisplayValue' => 'Robot white',
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
                    'DisplayValue' => 4,
                    'Label' => 'Height',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Length' =>
                  array (
                    'DisplayValue' => 17,
                    'Label' => 'Length',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                  'Weight' =>
                  array (
                    'DisplayValue' => 10.529999999999999,
                    'Label' => 'Weight',
                    'Locale' => 'en_US',
                    'Unit' => 'Pounds',
                  ),
                  'Width' =>
                  array (
                    'DisplayValue' => 11,
                    'Label' => 'Width',
                    'Locale' => 'en_US',
                    'Unit' => 'Inches',
                  ),
                ),
                'ReleaseDate' =>
                array (
                  'DisplayValue' => '2018-09-11T00:00:01Z',
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
                'DisplayValue' => 'Xbox One S 1TB Console - NBA 2K19 Bundle (Discontinued)',
                'Label' => 'Title',
                'Locale' => 'en_US',
              ),
              'TradeInInfo' =>
              array (
                'IsEligibleForTradeIn' => true,
                'Price' =>
                array (
                  'Amount' => 77.129999999999995,
                  'Currency' => 'USD',
                  'DisplayAmount' => '$77.13',
                ),
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
                    'MaxOrderQuantity' => 2,
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
                  'Id' => 'e6IGwB7tj3gpW4FZvwLyDTXQmGoRClcCWYrrLbgUeuclcZh6d1WyDz%2B0tcNT221eOgXifZ6rZPVqj3gOAXIWcul7ospGTW6g61LrR45h6SZfzSo7x9fUsQ%3D%3D',
                  'IsBuyBoxWinner' => true,
                  'MerchantInfo' =>
                  array (
                    'Id' => 'ATVPDKIKX0DER',
                    'Name' => 'Amazon.com',
                  ),
                  'Price' =>
                  array (
                    'Amount' => 219.34999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$219.35',
                    'Savings' =>
                    array (
                      'Amount' => 80.640000000000001,
                      'Currency' => 'USD',
                      'DisplayAmount' => '$80.64 (27%)',
                      'Percentage' => 27,
                    ),
                  ),
                  'ProgramEligibility' =>
                  array (
                    'IsPrimeExclusive' => false,
                    'IsPrimePantry' => false,
                  ),
                  'SavingBasis' =>
                  array (
                    'Amount' => 299.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$299.99',
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
                    'Amount' => 362.74000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$362.74',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 215.99000000000001,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$215.99',
                  ),
                  'OfferCount' => 33,
                ),
                1 =>
                array (
                  'Condition' =>
                  array (
                    'Value' => 'Used',
                  ),
                  'HighestPrice' =>
                  array (
                    'Amount' => 224.97,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$224.97',
                  ),
                  'LowestPrice' =>
                  array (
                    'Amount' => 165.53999999999999,
                    'Currency' => 'USD',
                    'DisplayAmount' => '$165.54',
                  ),
                  'OfferCount' => 12,
                ),
              ),
            ),
          ),
        );
    }
}
