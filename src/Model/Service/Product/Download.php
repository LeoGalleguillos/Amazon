<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Download
{
    public function __construct(
        AmazonService\Binding $bindingService,
        AmazonService\Brand $brandService,
        AmazonService\ProductGroup $productGroupService,
        AmazonTable\Product $productTable,
        AmazonTable\Product\EditorialReview $productEditorialReviewTable,
        AmazonTable\Product\Feature $productFeatureTable,
        AmazonTable\Product\Image $productImageTable
    ) {
        $this->bindingService              = $bindingService;
        $this->brandService                = $brandService;
        $this->productGroupService         = $productGroupService;
        $this->productTable                = $productTable;
        $this->productEditorialReviewTable = $productEditorialReviewTable;
        $this->productFeatureTable         = $productFeatureTable;
        $this->productImageTable           = $productImageTable;
    }

    public function downloadProduct(AmazonEntity\Product $productEntity)
    {
        $this->productTable->insertOnDuplicateKeyUpdate($productEntity);
        $this->productFeatureTable->insertProductIfNotExists(
            $productEntity
        );
        $this->productImageTable->insertProductIfNotExists(
            $productEntity
        );
        foreach ($productEntity->editorialReviews as $editorialReviewEntity) {
            $this->productEditorialReviewTable->insert(
                $productEntity->asin,
                $editorialReviewEntity->source,
                $editorialReviewEntity->content
            );
        }

        $this->productGroupService->insertIgnore(
            $productEntity->getProductGroup()
        );
        $this->bindingService->insertIgnore(
            $productEntity->binding
        );
        $this->brandService->insertIgnore(
            $productEntity->brand
        );
    }
}
