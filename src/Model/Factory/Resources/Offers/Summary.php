<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Resources\Offers;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Summary
{
    public function buildFromArray(array $array): AmazonEntity\Resources\Offers\Summary
    {
        $summaryEntity = (new AmazonEntity\Resources\Offers\Summary())
            ->setCondition($array['condition'])
            ->setOfferCount((int) $array['offer_count'])
            ;

        if (isset($array['highest_price'])) {
            $summaryEntity->setHighestPrice($array['highest_price']);
        }
        if (isset($array['lowest_price'])) {
            $summaryEntity->setLowestPrice($array['lowest_price']);
        }

        return $summaryEntity;
    }
}
