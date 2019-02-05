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
        StringService\Escape $escapeService
    ) {
        $this->breadcrumbsService = $breadcrumbsService;
        $this->productService     = $productService;
        $this->escapeService      = $escapeService;
    }

    public function __invoke(AmazonEntity\Product $productEntity): string
    {
        $browseNodeEntities = $this->productService->getBrowseNodes(
            $productEntity
        );

        if (get_class($browseNodeEntities->current() != AmazonEntity\BrowseNode::class) {
            throw new Exception('No browse nodes found.');
        }

        $browseNodeEntities = $this->breadcrumbsService->getBrowseNodes(
            $browseNodeEntities->current()
        );

        $html = "<ol class=\"breadcrumbs\">\n";
        foreach ($browseNodeEntities as $browseNodeEntity) {
            $nameEscaped = $this->escapeService->escape(
                $browseNodeEntity->getName()
            );
            $html .= "<li>$nameEscaped</li>\n";
        }
        $html .= '</ol>';

        return $html;
    }
}
