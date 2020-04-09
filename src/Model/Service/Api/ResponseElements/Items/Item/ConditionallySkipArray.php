<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items\Item;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

/**
 * This service should be called for potential new products only.
 * Presumably, we always want to update existing products regardless of the
 * pursuant conditions.
 *
 * @todo Move each block of logic to individual service.
 */
class ConditionallySkipArray
{
    public function __construct(
        AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Images $imagesService,
        AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\ParentAsin $parentAsinService,
        AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray\Title $titleService,
        AmazonService\Product\Banned $bannedService
    ) {
        $this->imagesService     = $imagesService;
        $this->parentAsinService = $parentAsinService;
        $this->titleService      = $titleService;
        $this->bannedService     = $bannedService;
    }

    public function shouldArrayBeSkipped(
        array $itemArray
    ): bool {
        if (empty($itemArray['ASIN'])) {
            return true;
        }

        $asin = $itemArray['ASIN'];

        // ASIN must be a B followed by nine alphanumeric characters.
        $pattern = '/^B\w{9}$/';
        if (!preg_match($pattern, $asin)) {
            return true;
        }

        // Return true if images should be skipped.
        if ($this->imagesService->shouldArrayBeSkipped($itemArray)) {
            return true;
        }

        // Return true if parent ASIN should be skipped.
        /*
        if ($this->parentAsinService->shouldArrayBeSkipped($itemArray)) {
            return true;
        }
         */

        // Return true if title should be skipped.
        if ($this->titleService->shouldArrayBeSkipped($itemArray)) {
            return true;
        }

        // ASIN must not be banned.
        if ($this->bannedService->isBanned($asin)) {
            return true;
        }

        // Item must not be an adult product.
        $isAdultProduct
            = $itemArray['ItemInfo']['ProductInfo']['IsAdultProduct']['DisplayValue']
            ?? null;
        if ($isAdultProduct) {
            return true;
        }

        // Item must not belong to the following list of product groups.
        $productGroup
            = $itemArray['ItemInfo']['Classifications']['ProductGroup']['DisplayValue']
            ?? null;
        $productGroupsToSkip = [
            'Book',
            'Classical',
            'Courseware',
            'Digital Ebook Purchas',
            'Digital Music Album',
            'Digital Music Purchase',
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
            'Video On Demand',
        ];
        if (in_array($productGroup, $productGroupsToSkip)) {
            return true;
        }

        return false;
    }
}
