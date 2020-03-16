<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items\Item;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\BrowseNodeInfo\SaveArrayToMySql $saveBrowseNodeInfoArrayToMySqlService,
        AmazonService\Api\Resources\Images\SaveArrayToMySql $saveImagesArrayToMySqlService,
        AmazonService\Api\Resources\ItemInfo\SaveArrayToMySql $saveItemInfoArrayToMySqlService,
        AmazonTable\Product\Asin $asinTable
    ) {
        $this->saveBrowseNodeInfoArrayToMySqlService = $saveBrowseNodeInfoArrayToMySqlService;
        $this->saveImagesArrayToMySqlService         = $saveImagesArrayToMySqlService;
        $this->saveItemInfoArrayToMySqlService       = $saveItemInfoArrayToMySqlService;
        $this->asinTable                             = $asinTable;
    }

    public function saveArrayToMySql(
        array $itemArray
    ) {
        $asin      = $itemArray['ASIN'];
        $productId = $this->asinTable->selectProductIdWhereAsin($asin)['product_id'];

        if (isset($itemArray['BrowseNodeInfo'])) {
            $this->saveBrowseNodeInfoArrayToMySqlService->saveArrayToMySql(
                $itemArray['BrowseNodeInfo'],
                $productId
            );
        }

        if (isset($itemArray['Images'])) {
            $this->saveImagesArrayToMySqlService->saveArrayToMySql(
                $itemArray['Images'],
                $productId
            );
        }

        if (isset($itemArray['ItemInfo'])) {
            $this->saveItemInfoArrayToMySqlService->saveArrayToMySql(
                $itemArray['ItemInfo'],
                $productId
            );
        }
    }
}
