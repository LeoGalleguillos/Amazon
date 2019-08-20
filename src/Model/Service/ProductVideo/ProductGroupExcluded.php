<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use TypeError;

class ProductGroupExcluded
{
    public function isProductGroupExcluded(AmazonEntity\Product $productEntity): bool
    {
        try {
            $productGroupName = $productEntity->getProductGroup()->getName();
        } catch (TypeError $typeError) {
            return false;
        }

        $excludedProductGroups = [
            'Book',
            'Classical',
            'Courseware',
            'Digital Music Album',
            'Digital Music Track',
            'DVD',
            'eBooks',
            'Movie',
            'Music',
            'Single Detail Page Misc',
            'Television',
            'TV Series Season Video on Demand',
            'TV Series Video on Demand',
            'Video',
        ];

        return in_array(
            $productGroupName,
            $excludedProductGroups
        );
    }
}
