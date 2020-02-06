<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\BrowseNodeInfo;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class DownloadArrayToMySql
{
    public function __construct(
        AmazonService\Api\Resources\BrowseNodes\BrowseNode\DownloadArrayToMySql $downloadBrowseNodeArrayToMySqlService,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable
    ) {
        $this->downloadBrowseNodeArrayToMySqlService = $downloadBrowseNodeArrayToMySqlService;
        $this->browseNodeProductTable                = $browseNodeProductTable;
    }

    public function downloadArrayToMySql(
        array $browseNodeInfoArray,
        int $productId
    ) {
        if (isset($browseNodeInfoArray['BrowseNodes'])) {
            $order = 1;
            foreach ($browseNodeInfoArray['BrowseNodes'] as $browseNodeArray) {
                $this->downloadBrowseNodeArrayToMySqlService->downloadArrayToMySql($browseNodeArray);

                $browseNodeId = $browseNodeArray['Id'];
                $this->browseNodeProductTable->insertOnDuplicateKeyUpdate(
                    $browseNodeId,
                    $productId,
                    $order
                );
                $order++;
            }
        }
    }
}
