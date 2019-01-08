<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class BrowseNodeIds
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes $browseNodesService
    ) {
        $this->browseNodesService = $browseNodesService;
    }

    public function getBrowseNodeIds(string $name): Generator
    {
        $generator = $this->browseNodesService->getBrowseNodes($name);

        foreach ($generator as $browseNodeEntity) {
            yield $browseNodeEntity->getBrowseNodeId();
        }
    }
}
