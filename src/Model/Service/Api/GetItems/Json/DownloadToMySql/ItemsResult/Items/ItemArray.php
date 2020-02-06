<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class ItemArray
{
    public function __construct(
        AmazonService\Api\Resources\BrowseNodes\BrowseNode\DownloadArrayToMySql $downloadArrayToMySqlService,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->downloadArrayToMySqlService = $downloadArrayToMySqlService;
        $this->browseNodeProductTable      = $browseNodeProductTable;
        $this->asinTable                   = $asinTable;
    }

    public function downloadToMySql(
        array $itemArray
    ): bool {
        $asin      = $itemArray['ASIN'];
        $productId = $this->asinTable->selectProductIdWhereAsin($asin)['product_id'];

        if (isset($itemArray['BrowseNodeInfo']['BrowseNodes'])) {
            $order = 1;
            foreach ($itemArray['BrowseNodeInfo']['BrowseNodes'] as $browseNodeArray) {
                $this->downloadArrayToMySqlService->downloadArrayToMySql($browseNodeArray);

                $browseNodeId = $browseNodeArray['Id'];
                $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
                    $browseNodeId,
                    $productId,
                    $order
                );
                $order++;
            }
        }

        return true;
    }
}
