<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TestCase
{
    protected function setUp()
    {
        $this->saveSummariesArrayToMySqlServiceMock = $this->createMock(
            AmazonService\Api\Resources\Offers\Summaries\SaveArrayToMySql::class
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Offers\SaveArrayToMySql(
            $this->saveSummariesArrayToMySqlServiceMock
        );
    }

    public function test_saveArrayToMySql_emptyArray_doNothing()
    {
        $this->saveSummariesArrayToMySqlServiceMock
            ->expects($this->never())
            ->method('saveArrayToMySql');
        $this->saveArrayToMySqlService->saveArrayToMySql(
            [],
            12345
        );
    }

    public function test_saveArrayToMySql_nonEmptyArray_doStuff()
    {
        $this->saveSummariesArrayToMySqlServiceMock
            ->expects($this->once())
            ->method('saveArrayToMySql')
            ->with(
                $this->getOffersArray()['Summaries']
            );
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getOffersArray(),
            12345
        );
    }

    protected function getOffersArray(): array
    {
        return array (
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
        );
    }
}
