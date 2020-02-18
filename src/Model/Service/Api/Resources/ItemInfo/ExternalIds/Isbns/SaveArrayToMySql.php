<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ExternalIds\Isbns;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\ProductIsbn $productIsbnTable
    ) {
        $this->productIsbnTable = $productIsbnTable;
    }

    public function saveArrayToMySql(
        array $isbnsArray,
        int $productId
    ) {
        if (empty($isbnsArray['DisplayValues'])) {
            return;
        }

        foreach ($isbnsArray['DisplayValues'] as $isbn) {
            $this->productIsbnTable->insertIgnore(
                $productId,
                $isbn
            );
        }
    }
}
