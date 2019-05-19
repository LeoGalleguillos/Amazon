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
        AmazonService\Product\Breadcrumbs $breadcrumbsService,
        StringService\Escape $escapeService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->browseNodeNameDomains = $browseNodeNameDomains;
        $this->breadcrumbsService    = $breadcrumbsService;
        $this->escapeService         = $escapeService;
        $this->urlFriendlyService    = $urlFriendlyService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(AmazonEntity\Product $productEntity): string
    {
        $browseNodeEntities = $this->breadcrumbsService->getBreadcrumbs(
            $productEntity
        );

        if (empty($browseNodeEntities)) {
            throw new Exception('No browse nodes found for product.');
        }

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
