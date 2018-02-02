<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Download
{
    public function __construct(
        AmazonService\Binding $amazonBindingService,
        AmazonService\Brand $amazonBrandService,
        AmazonService\ProductGroup $amazonProductGroupService,
        AmazonTable\Product $amazonProductTable,
        AmazonTable\Product\EditorialReview $amazonProductEditorialReviewTable,
        AmazonTable\Product\Feature $amazonProductFeatureTable,
        AmazonTable\Product\Image $amazonProductImageTable
    ) {
        $this->amazonBindingService              = $amazonBindingService;
        $this->amazonBrandService                = $amazonBrandService;
        $this->amazonProductGroupService         = $amazonProductGroupService;
        $this->amazonProductTable                = $amazonProductTable;
        $this->amazonProductEditorialReviewTable = $amazonProductEditorialReviewTable;
        $this->amazonProductFeatureTable         = $amazonProductFeatureTable;
        $this->amazonProductImageTable           = $amazonProductImageTable;
    }

    public function downloadProduct(AmazonEntity\Product $amazonProductEntity)
    {
        $this->amazonProductTable->insertProductIfNotExists($amazonProductEntity);
        $this->amazonProductFeatureTable->insertProductIfNotExists(
            $amazonProductEntity
        );
        $this->amazonProductImageTable->insertProductIfNotExists(
            $amazonProductEntity
        );
        foreach ($amazonProductEntity->editorialReviews as $editorialReviewEntity) {
            $this->amazonProductEditorialReviewTable->insert(
                $amazonProductEntity->asin,
                $editorialReviewEntity->source,
                $editorialReviewEntity->content
            );
        }

        $this->amazonProductGroupService->insertIgnore(
            $amazonProductEntity->productGroup
        );
        $this->amazonBindingService->insertIgnore(
            $amazonProductEntity->binding
        );
        $this->amazonBrandService->insertIgnore(
            $amazonProductEntity->brand
        );
    }
}
