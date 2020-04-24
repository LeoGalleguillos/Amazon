<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Offers\Summaries;

use Laminas\Db\TableGateway\TableGateway;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class SaveArrayToMySql
{
    public function __construct(
        TableGateway $resourcesOffersSummariesTableGateway
    ) {
        $this->resourcesOffersSummariesTableGateway = $resourcesOffersSummariesTableGateway;
    }

    public function saveArrayToMySql(
        array $summariesArray,
        int $productId
    ) {
        $connection = $this->resourcesOffersSummariesTableGateway
            ->getAdapter()
            ->getDriver()
            ->getConnection();
        $connection->beginTransaction();

        $this->resourcesOffersSummariesTableGateway->delete(['product_id' => $productId]);

        foreach ($summariesArray as $summaryArray) {
            $this->resourcesOffersSummariesTableGateway->insert([
                'product_id' => $productId,
                'condition' => $summaryArray['Condition']['Value'],
                'highest_price' => $summaryArray['HighestPrice']['Amount'] ?? null,
                'lowest_price' => $summaryArray['LowestPrice']['Amount'] ?? null,
                'offer_count' => $summaryArray['OfferCount'],
            ]);
        }

        $connection->commit();
    }
}
