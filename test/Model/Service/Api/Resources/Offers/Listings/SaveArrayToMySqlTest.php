<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Offers\Listings;

use ArrayObject;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGateway;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Test\TableTestCase;

class SaveArrayToMySqlTest extends TableTestCase
{
    protected function setUp()
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('resources_offers_listings');
        $this->resourcesOffersListingsTableGateway = new TableGateway(
            'resources_offers_listings',
            $this->getAdapter()
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Offers\Listings\SaveArrayToMySql(
            $this->resourcesOffersListingsTableGateway
        );
    }

    public function test_saveArrayToMySql_multipleSummaries_multipleInserts()
    {
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSummariesArray(),
            12345
        );

        $result = $this->resourcesOffersListingsTableGateway
            ->select(['product_id' => 12345]);
        $this->assertEquals(
			new ArrayObject([
			   'resources_offers_listings_id' => '1',
			   'product_id' => '12345',
               'availability' => 'In Stock.',
               'minimum_order_quantity' => '1',
               'maximum_order_quantity' => '3',
			   'condition' => 'New',
			   'sub_condition' => 'New',
               'is_fulfilled_by_amazon' => '1',
               'is_eligible_for_free_shipping' => '1',
               'is_eligible_for_prime' => '1',
               'merchant_id' => 'ATVPDKIKX0DER',
               'merchant_name' => 'Amazon.com',
               'price' => '4.00',
               'savings' => '3.99',
               'is_prime_exclusive' => '0',
               'is_prime_pantry' => '0',
               'violates_map' => '0',

			]),
			$result->current()
        );
    }

    public function test_saveArrayToMySql_runTwice_previousRowsDeleted()
    {
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSummariesArray(),
            12345
        );
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSummariesArray(),
            54321
        );
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSummariesArray(),
            12345
        );

        $result = $this->resourcesOffersListingsTableGateway
            ->select(function (Select $select) {
                $select->columns([
                    'count' => new \Laminas\Db\Sql\Expression("COUNT(*)")
                ]);
            });
        $this->assertSame(
            '2',
            $result->current()['count']
        );
    }

    protected function getSummariesArray(): array
    {
        return array (
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
        );
    }
}
