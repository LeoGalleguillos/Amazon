<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use MonthlyBasis\String\Model\Service as StringService;

class RootRelativeUrl
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsBrowseNodesService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->breadcrumbsBrowseNodesService = $breadcrumbsBrowseNodesService;
        $this->urlFriendlyService            = $urlFriendlyService;
    }

    public function getRootRelativeUrl(AmazonEntity\BrowseNode $browseNodeEntity): string
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
