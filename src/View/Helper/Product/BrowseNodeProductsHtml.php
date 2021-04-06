<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use MonthlyBasis\String\Model\Service as StringService;
use TypeError;
use Laminas\View\Helper\AbstractHelper;

class BrowseNodeProductsHtml extends AbstractHelper
{
    public function __construct(
        AmazonHelper\BrowseNodeProduct\BreadcrumbsHtml $breadcrumbsHtmlHelper,
        AmazonService\Product\BrowseNodeProducts $browseNodeProductsService
    ) {
        $this->breadcrumbsHtmlHelper     = $breadcrumbsHtmlHelper;
        $this->browseNodeProductsService = $browseNodeProductsService;
    }

    public function __invoke(AmazonEntity\Product $productEntity): string
    {
        $browseNodeProductEntities = $this->browseNodeProductsService->getBrowseNodeProducts(
            $productEntity
        );

        if (empty($browseNodeProductEntities)) {
            return '';
        }

        $html = "<ol class=\"browse-node-products\">\n";

        foreach ($browseNodeProductEntities as $browseNodeProductEntity) {
            $liHtml = '<li>';

            try {
                $liHtml .= '<b>Rank #' . number_format($browseNodeProductEntity->getSalesRank()) . '</b> in ';
            } catch (TypeError $typeError) {
                $liHtml .= '';
            }

            $liHtml .= $this->breadcrumbsHtmlHelper->__invoke($browseNodeProductEntity);

            $liHtml .= '</li>';

            $html .= $liHtml . "\n";
        }

        $html .= '</ol>';

        return $html;
    }
}
