<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Breadcrumbs
{
    public function __construct(
        AmazonService\BrowseNode\BrowseNodes\Breadcrumbs $breadcrumbsService,
        AmazonService\BrowseNode\BrowseNodes\Product $productService
    ) {
        $this->breadcrumbsService = $breadcrumbsService;
        $this->productService     = $productService;
    }

    /**
     * @return AmazonEntity\BrowseNode[]
     */
    public function getBreadcrumbs(AmazonEntity\Product $productEntity): array
    {
        $browseNodeEntities = $this->productService->getBrowseNodes(
            $productEntity
        );

        return $this->breadcrumbsService->getBrowseNodes(
            $browseNodeEntities[0]
        );
    }
}
