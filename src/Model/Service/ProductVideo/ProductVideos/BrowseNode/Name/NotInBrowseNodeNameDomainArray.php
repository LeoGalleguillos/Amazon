<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos\BrowseNode\Name;

use Generator;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class NotInBrowseNodeNameDomainArray
{
    public function __construct(
        AmazonService\BrowseNodeNameDomain\Names $namesService,
        AmazonService\ProductVideo\ProductVideos\BrowseNode\Name\NotIn $notInService
    ) {
        $this->namesService = $namesService;
        $this->notInService = $notInService;
    }

    public function getProductVideos(
        int $page
    ): Generator {
        return $this->notInService->getProductVideos(
            $this->namesService->getNames(),
            $page
        );
    }
}
