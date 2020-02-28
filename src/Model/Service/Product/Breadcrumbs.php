<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Breadcrumbs
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        AmazonService\Product\BrowseNodeProducts $browseNodeProductsService
    ) {
        $this->breadcrumbsService        = $breadcrumbsService;
        $this->browseNodeProductsService = $browseNodeProductsService;
    }

    /**
     * @return AmazonEntity\BrowseNode[]
     */
    public function getBreadcrumbs(AmazonEntity\Product $productEntity): array
    {
        /* @var array $browseNodeProducts */
        $browseNodeProducts = $this->browseNodeProductsService->getBrowseNodeProducts(
            $productEntity
        );

        if (empty($browseNodeProducts)) {
            return [];
        }

        return $this->breadcrumbsService->getBrowseNodes(
            $browseNodeProducts[0]->getBrowseNode()
        );
    }
}
