<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Api\Resources\Offers\Summaries;

use ArrayObject;
use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGateway;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Test\TableTestCase;
use PHPUnit\Framework\TestCase;

class SaveArrayToMySqlTest extends TableTestCase
{
    protected function setUp(): void
    {
        $this->setForeignKeyChecks(0);
        $this->dropAndCreateTable('resources_offers_summaries');
        $this->resourcesOffersSummariesTableGateway = new TableGateway(
            'resources_offers_summaries',
            $this->getAdapter()
        );
        $this->saveArrayToMySqlService = new AmazonService\Api\Resources\Offers\Summaries\SaveArrayToMySql(
            $this->resourcesOffersSummariesTableGateway
        );
    }

    public function test_saveArrayToMySql_multipleSummaries_multipleInserts()
    {
        $this->saveArrayToMySqlService->saveArrayToMySql(
            $this->getSummariesArray(),
            12345
        );

        $result = $this->resourcesOffersSummariesTableGateway
            ->select(['product_id' => 12345]);
        $this->assertEquals(
			new ArrayObject([
			   'resources_offers_summaries_id' => '1',
			   'product_id' => '12345',
			   'condition' => 'New',
			   'highest_price' => '79.99',
			   'lowest_price' => '79.99',
			   'offer_count' => '1',
			]),
			$result->current()
        );
        $result->next();
        $this->assertEquals(
            new ArrayObject([
                'resources_offers_summaries_id' => '2',
                'product_id' => '12345',
                'condition' => 'Used',
                'highest_price' => null,
                'lowest_price' => null,
                'offer_count' => '3',
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

        $result = $this->resourcesOffersSummariesTableGateway
            ->select(function (Select $select) {
                $select->columns([
                    'count' => new \Laminas\Db\Sql\Expression("COUNT(*)")
                ]);
            });
        $this->assertSame(
            '4',
            $result->current()['count']
        );
    }

    protected function getSummariesArray(): array
    {
        return array (
          0 =>
          array (
            'Condition' =>
            array (
              'Value' => 'New',
            ),
            'HighestPrice' =>
            array (
              'Amount' => 79.99,
              'Currency' => 'USD',
              'DisplayAmount' => '$79.99',
            ),
            'LowestPrice' =>
            array (
              'Amount' => 79.99,
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
            'OfferCount' => 3,
          ),
        );
    }
}
