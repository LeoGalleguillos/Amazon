<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ExternalIds\Upcs;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\ProductUpc $productUpcTable
    ) {
        $this->productUpcTable = $productUpcTable;
    }

    public function saveArrayToMySql(
        array $upcsArray,
        int $productId
    ) {
        if (empty($upcsArray['DisplayValues'])) {
            return;
        }

        foreach ($upcsArray['DisplayValues'] as $upc) {
            $this->productUpcTable->insertIgnore(
                $productId,
                $upc
            );
        }
    }
}
