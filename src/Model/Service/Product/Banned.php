<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Banned
{
    public function __construct(
        AmazonTable\ProductBanned $productBannedTable
    ) {
        $this->productBannedTable = $productBannedTable;
    }

    public function isBanned(
        string $asin
    ): bool {
        $result = $this->productBannedTable->selectCountWhereAsin($asin);

        return ($result->current()['COUNT(*)'] > 0);
    }
}
