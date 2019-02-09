<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class RootRelativeUrl
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsBrowseNodesService
    ) {
        $this->breadcrumbsBrowseNodesService = $breadcrumbsBrowseNodesService;
    }

    public function getRootRelativeUrl(AmazonEntity $browseNodeEntity): string
    {
        $browseNodeEntities = $this->breadcrumbsBrowseNodesService->getBrowseNodes(
            $browseNodeEntity
        );

        $rootRelativeUrl = '/categories';

        foreach ($browseNodeEntities as $browseNodeEntity) {
            $nameUrlFriendly = $this->urlFriendlyService->getUrlFriendly(
                $browseNodeEntity->getName()
            );
            $rootRelativeUrl .= '/'
                . $browseNodeEntity->getBrowseNodeId()
                . '/'
                . $nameUrlFriendly;
        }

        return $rootRelativeUrl;
    }
}
