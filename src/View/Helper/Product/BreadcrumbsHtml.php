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
        array $browseNodeNameDomains,
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        AmazonService\BrowseNode\BrowseNodes\Product $productService,
        StringService\Escape $escapeService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->browseNodeNameDomains = $browseNodeNameDomains;
        $this->breadcrumbsService    = $breadcrumbsService;
        $this->productService        = $productService;
        $this->escapeService         = $escapeService;
        $this->urlFriendlyService    = $urlFriendlyService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(AmazonEntity\Product $productEntity): string
    {
        $browseNodeEntities = $this->productService->getBrowseNodes(
            $productEntity
        );

        if (empty($browseNodeEntities)) {
            throw new Exception('No browse nodes found for product.');
        }

        $browseNodeEntities = $this->breadcrumbsService->getBrowseNodes(
            $browseNodeEntities[0]
        );

        $defaultDomain = $this->browseNodeNameDomains['default'];

        $href = ($_SERVER['HTTP_HOST'] == $defaultDomain)
            ? '/categories'
            : 'https://' . $defaultDomain . '/categories';

        $html = "<ol class=\"breadcrumbs\">\n";

        foreach ($browseNodeEntities as $browseNodeEntity) {
            $browseNodeName  = $browseNodeEntity->getName();
            $nameUrlFriendly = $this->urlFriendlyService->getUrlFriendly(
                $browseNodeName
            );
            $href .= '/'
                . $browseNodeEntity->getBrowseNodeId()
                . '/'
                . $nameUrlFriendly;
            $nameEscaped = $this->escapeService->escape(
                $browseNodeEntity->getName()
            );

            if (isset($this->browseNodeNameDomains[$browseNodeName])) {
                $domain = $this->browseNodeNameDomains[$browseNodeName];
                $html .= "<li><a href=\"https://$domain\">$nameEscaped</a></li>\n";
            } else {
                $html .= "<li><a href=\"$href\">$nameEscaped</a></li>\n";
            }
        }

        $html .= '</ol>';

        return $html;
    }
}
