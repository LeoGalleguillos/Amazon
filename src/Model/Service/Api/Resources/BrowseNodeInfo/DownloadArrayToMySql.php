<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\BrowseNodeInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class DownloadArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\BrowseNodes\BrowseNode\SaveArrayToMySql $saveBrowseNodeArrayToMySqlService,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->saveBrowseNodeArrayToMySqlService = $saveBrowseNodeArrayToMySqlService;
        $this->browseNodeProductTable            = $browseNodeProductTable;
    }

    public function downloadArrayToMySql(
        array $browseNodeInfoArray,
        int $productId
    ) {
        if (isset($browseNodeInfoArray['BrowseNodes'])) {
            $order = 1;
            foreach ($browseNodeInfoArray['BrowseNodes'] as $browseNodeArray) {
                $this->saveBrowseNodeArrayToMySqlService->saveArrayToMySql($browseNodeArray);

                $browseNodeId = $browseNodeArray['Id'];
                $salesRank    = $browseNodeArray['SalesRank'] ?? null;

                $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
                    $browseNodeId,
                    $productId,
                    $salesRank,
                    $order
                );
                $order++;
            }
        }
    }
}
