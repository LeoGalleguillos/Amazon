<?php
namespace LeoGalleguillos\Amazon\View\Helper\BrowseNodeProduct;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use Laminas\View\Helper\AbstractHelper;

class BreadcrumbsHtml extends AbstractHelper
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        array $browseNodeNameDomains,
        StringService\Escape $escapeService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->breadcrumbsService    = $breadcrumbsService;
        $this->browseNodeNameDomains = $browseNodeNameDomains;
        $this->escapeService         = $escapeService;
        $this->urlFriendlyService    = $urlFriendlyService;
    }

    public function __invoke(
        AmazonEntity\BrowseNodeProduct $browseNodeProductEntity
    ): string {
        $browseNodeEntities = $this->breadcrumbsService->getBrowseNodes(
            $browseNodeProductEntity->getBrowseNode()
        );

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

            if (isset($this->browseNodeNameDomains[$browseNodeEntity->getName()])) {
                $domain = $this->browseNodeNameDomains[$browseNodeEntity->getName()];
                $html .= "<li><a href=\"https://$domain\">$nameEscaped</a></li>\n";
            } else {
                $html .= "<li><a href=\"$href\">$nameEscaped</a></li>\n";
            }
        }

        $html .= '</ol>';

        return $html;
    }
}
