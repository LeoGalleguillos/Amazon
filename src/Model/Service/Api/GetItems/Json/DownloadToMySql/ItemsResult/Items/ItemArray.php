<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class ItemArray
{
    public function __construct(
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray $browseNodeArrayService,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->browseNodeArrayService = $browseNodeArrayService;
        $this->browseNodeProductTable = $browseNodeProductTable;
        $this->asinTable              = $asinTable;
    }

    public function downloadToMySql(
        array $itemArray
    ): bool {
        $asin      = $itemArray['ASIN'];
        $productId = $this->asinTable->selectProductIdWhereAsin($asin);

        if (isset($itemArray['BrowseNodeInfo']['BrowseNodes'])) {
            $order = 1;
            foreach ($itemArray['BrowseNodeInfo']['BrowseNodes'] as $browseNodeArray) {
                $this->browseNodeArrayService->downloadToMySql($browseNodeArray);

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