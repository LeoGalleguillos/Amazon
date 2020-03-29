<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\ResponseElements\Items\Item\ConditionallySkipArray $conditionallySkipItemArrayService,
        AmazonService\Api\ResponseElements\Items\Item\SaveArrayToMySql $saveItemArrayToMySqlService,
        AmazonTable\Product $productTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->conditionallySkipItemArrayService = $conditionallySkipItemArrayService;
        $this->saveItemArrayToMySqlService       = $saveItemArrayToMySqlService;
        $this->productTable                      = $productTable;
        $this->asinTable                         = $asinTable;
    }

    /**
     * Think carefully before moving around this logic.
     *
     * For example, it's tempting to always update `modified`. However,
     * we cannot do this for new products until after the `asin` is inserted.
     * And, we do not want to insert the new `asin` for all arrays.
     *
     * Also, we still want to update `is_valid` and `modified` for arrays
     * that we are skipping because we don't want to parse those first in
     * any external loops that order by `modified` ASC.
     */
    public function saveArrayToMySql(
        array $itemsArray
    ) {
        foreach ($itemsArray as $itemArray) {
            $asin         = $itemArray['ASIN'];
            $productArray = $this->asinTable->selectWhereAsin($asin)->current();

            // If product exists, then update `is_valid` and `modified`.
            if ($productArray) {
                $this->asinTable->updateSetIsValidWhereAsin(1, $asin);
                $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin($asin);
            }

            // Conditionally skip array.
            if ($this->conditionallySkipItemArrayService->shouldArrayBeSkipped($itemArray)) {
                continue;
            }

            // If product does not exist, then insert `asin` and update `modified`.
            if (!$productArray) {
                $this->productTable->insertAsin($asin);
                $this->asinTable->updateSetModifiedToUtcTimestampWhereAsin($asin);
            }

            // Save array.
            $this->saveItemArrayToMySqlService->saveArrayToMySql(
                $itemArray
            );
        }
    }
}
