<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ItemArray
{
    public function __construct(
        AmazonService\Api\Resources\BrowseNodeInfo\DownloadArrayToMySql $downloadBrowseNodeInfoArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\DownloadArrayToMySql $downloadItemInfoArrayToMySqlService,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->downloadBrowseNodeInfoArrayToMySqlService = $downloadBrowseNodeInfoArrayToMySqlService;
        $this->downloadItemInfoArrayToMySqlService       = $downloadItemInfoArrayToMySqlService;
        $this->asinTable                                 = $asinTable;
    }

    public function downloadToMySql(
        array $itemArray
    ) {
        $asin      = $itemArray['ASIN'];
        $productId = $this->asinTable->selectProductIdWhereAsin($asin)['product_id'];

        if (isset($itemArray['BrowseNodeInfo'])) {
            $this->downloadBrowseNodeInfoArrayToMySqlService->downloadArrayToMySql(
                $itemArray['BrowseNodeInfo'],
                $productId
            );
        }

        if (isset($itemArray['ItemInfo'])) {
            $this->downloadItemInfoArrayToMySqlService->downloadArrayToMySql(
                $itemArray['ItemInfo'],
                $productId
            );
        }
    }
}
