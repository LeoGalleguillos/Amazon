<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ItemArray
{
    public function __construct(
        AmazonTable\Product $productTable
    ) {
        $this->productTable = $productTable;
    }

    public function downloadToMySql(
        array $itemArray
    ): bool {
        return true;
    }
}
