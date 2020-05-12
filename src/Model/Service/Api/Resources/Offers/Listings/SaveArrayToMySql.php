<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Offers\Listings;

use Laminas\Db\TableGateway\TableGateway;

class SaveArrayToMySql
{
    public function __construct(
        TableGateway $resourcesOffersListingsTableGateway
    ) {
        $this->resourcesOffersListingsTableGateway = $resourcesOffersListingsTableGateway;
    }

    public function saveArrayToMySql(
        array $listingsArray,
        int $productId
    ) {
        $connection = $this->resourcesOffersListingsTableGateway
            ->getAdapter()
            ->getDriver()
            ->getConnection();
        $connection->beginTransaction();

        $this->resourcesOffersListingsTableGateway->delete(['product_id' => $productId]);

        foreach ($listingsArray as $listingArray) {
            $this->resourcesOffersListingsTableGateway->insert([
                'product_id' => $productId,
                'availability' => $listingArray['Availability']['Message'],
                'minimum_order_quantity' => $listingArray['Availability']['MinOrderQuantity'],
                'maximum_order_quantity' => $listingArray['Availability']['MaxOrderQuantity'] ?? null,
                'condition' => $listingArray['Condition']['Value'],
                'sub_condition' => $listingArray['Condition']['SubCondition']['Value'],
                'is_fulfilled_by_amazon' => $listingArray['DeliveryInfo']['IsAmazonFulfilled'],
                'is_eligible_for_free_shipping' => $listingArray['DeliveryInfo']['IsFreeShippingEligible'],
                'is_eligible_for_prime' => $listingArray['DeliveryInfo']['IsPrimeEligible'],
                'merchant_id' => $listingArray['MerchantInfo']['Id'],
                'merchant_name' => $listingArray['MerchantInfo']['Name'] ?? null,
                'price' => $listingArray['Price']['Amount'] ?? null,
                'savings' => $listingArray['Price']['Savings']['Amount'] ?? null,
                'is_prime_exclusive' => $listingArray['ProgramEligibility']['IsPrimeExclusive'],
                'is_prime_pantry' => $listingArray['ProgramEligibility']['IsPrimePantry'],
                'violates_map' => $listingArray['ViolatesMAP'],
            ]);
        }

        $connection->commit();
    }
}
