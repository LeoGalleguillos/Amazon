<?php
namespace LeoGalleguillos\Amazon\View\Helper\BrowseNode;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;

class BreadcrumbsHtml extends AbstractHelper
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        StringService\Escape $escapeService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->breadcrumbsService = $breadcrumbsService;
        $this->escapeService      = $escapeService;
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function __invoke(AmazonEntity\BrowseNode $browseNodeEntity): string
    {
        $browseNodeEntities = $this->breadcrumbsService->getBrowseNodes(
            $browseNodeEntity
        );

        array_pop($browseNodeEntities);

        $href = '/categories';
        $html = "<ol class=\"breadcrumbs\">\n";

        foreach ($browseNodeEntities as $browseNodeEntity) {
            $nameUrlFriendly = $this->urlFriendlyService->getUrlFriendly(
                $browseNodeEntity->getName()
            );
            $href .= '/'
                . $browseNodeEntity->getBrowseNodeId()
                . '/'
                . $nameUrlFriendly;
            $nameEscaped = $this->escapeService->escape(
                $browseNodeEntity->getName()
            );
            $html .= "<li><a href=\"$href\">$nameEscaped</a></li>\n";
        }

        $html .= '</ol>';

        return $html;
    }
}
