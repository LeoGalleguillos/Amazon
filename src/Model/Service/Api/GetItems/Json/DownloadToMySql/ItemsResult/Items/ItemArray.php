<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items;

use LeoGalleguillos\Amazon\{
    Model\Service as AmazonService,
    Model\Table as AmazonTable
};

class ItemArray
{
    public function __construct(
        AmazonService\Api\GetItems\Json\DownloadToMySql\ItemsResult\Items\BrowseNodeInfo\BrowseNodes\BrowseNodeArray $browseNodeArrayService
    ) {
        $this->browseNodeArrayService = $browseNodeArrayService;
    }

    public function downloadToMySql(
        array $itemArray
    ): bool {
        if (isset($itemArray['BrowseNodeInfo']['BrowseNodes'])) {
            $browseNodesArray = $itemArray['BrowseNodeInfo']['BrowseNodes'];
            foreach ($browseNodesArray as $browseNodeArray) {
                $this->browseNodeArrayService->downloadToMySql($browseNodeArray);
            }
        }

        return true;
    }
}
