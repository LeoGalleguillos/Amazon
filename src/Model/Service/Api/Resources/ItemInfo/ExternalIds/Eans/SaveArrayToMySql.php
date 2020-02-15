<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ExternalIds\Eans;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\ProductEan $productEanTable
    ) {
        $this->productEanTable = $productEanTable;
    }

    public function saveArrayToMySql(
        array $eansArray,
        int $productId
    ) {

    }
}
