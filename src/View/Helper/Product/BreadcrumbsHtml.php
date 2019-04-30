<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;
use Zend\View\Helper\AbstractHelper;

class BreadcrumbsHtml extends AbstractHelper
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        AmazonService\BrowseNode\BrowseNodes\Product $productService,
        StringService\Escape $escapeService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->breadcrumbsService = $breadcrumbsService;
        $this->productService     = $productService;
        $this->escapeService      = $escapeService;
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function __invoke(AmazonEntity\Product $productEntity): string
    {
        $browseNodeEntities = $this->productService->getBrowseNodes(
            $productEntity
        );

        $browseNodeEntities = $this->breadcrumbsService->getBrowseNodes(
            $browseNodeEntities[0]
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
            $html .= "<li><a href=\"$href\">$nameEscaped</a></li>\n";
        }

        $html .= '</ol>';

        return $html;
    }
}
