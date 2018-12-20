<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use DateTime;
use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;

class Product
{
    public function __construct(
        AmazonFactory\Binding $amazonBindingFactory,
        AmazonFactory\Brand $amazonBrandFactory,
        AmazonFactory\Product\EditorialReview $amazonProductEditorialReviewFactory,
        AmazonFactory\ProductGroup $amazonProductGroupFactory,
        ImageFactory\Image $imageFactory,
        AmazonTable\Product $amazonProductTable,
        AmazonTable\Product\EditorialReview $amazonProductEditorialReviewTable,
        AmazonTable\ProductFeature $amazonProductFeatureTable,
        AmazonTable\ProductImage $amazonProductImageTable,
        AmazonTable\ProductHiResImage $productHiResImageTable
    ) {
        $this->amazonBindingFactory                = $amazonBindingFactory;
        $this->amazonBrandFactory                  = $amazonBrandFactory;
        $this->amazonProductEditorialReviewFactory = $amazonProductEditorialReviewFactory;
        $this->amazonProductGroupFactory           = $amazonProductGroupFactory;
        $this->imageFactory                        = $imageFactory;
        $this->amazonProductTable                  = $amazonProductTable;
        $this->amazonProductEditorialReviewTable   = $amazonProductEditorialReviewTable;
        $this->amazonProductFeatureTable           = $amazonProductFeatureTable;
        $this->amazonProductImageTable             = $amazonProductImageTable;
        $this->productHiResImageTable              = $productHiResImageTable;
    }

    public function buildFromArray(
        array $productArray
    ) {
        $productEntity = new AmazonEntity\Product();

        $productEntity->setAsin($productArray['asin'])
                      ->setListPrice($productArray['list_price'])
                      ->setProductId($productArray['product_id'])
                      ->setTitle($productArray['title']);

        $productEntity->productGroup = $productArray['product_group'];

        if (isset($productArray['binding'])) {
            $productEntity->binding = $productArray['binding'];
        }

        if (isset($productArray['brand'])) {
            $productEntity->brand = $productArray['brand'];
        }

        if (isset($productArray['hi_res_images_retrieved'])) {
            $productEntity->setHiResImagesRetrieved(
                new DateTime($productArray['hi_res_images_retrieved'])
            );
        }

        if (isset($productArray['video_generated'])) {
            $productEntity->setVideoGenerated(
                new DateTime($productArray['video_generated'])
            );
        }

        return $productEntity;
    }

    protected function buildFromArrays(
        array $productArray,
        Generator $productFeatureArrays,
        Generator $productHiResImageArrays,
        Generator $productImageArrays
    ) {
        // In progress, do not use yet.

        $productEntity = new AmazonEntity\Product();

        $productEntity->setAsin($productArray['asin'])
                      ->setProductId($productArray['product_id'])
                      ->setTitle($productArray['title']);

        if (isset($productArray['hi_res_images_retrieved'])) {
            $productEntity->setHiResImagesRetrieved(
                new DateTime($productArray['hi_res_images_retrieved'])
            );

            $hiResImages = [];
            $generator = $this->productHiResImageTable->selectWhereProductId(
                $productEntity->getProductId()
            );
            foreach ($generator as $productHiResImageArray) {
                $imageEntity = new ImageEntity\Image();
                $imageEntity->setUrl($productHiResImageArray['url']);
                $hiResImages[] = $imageEntity;
            }

            $productEntity->setHiResImages($hiResImages);
        }

        if (isset($productArray['video_generated'])) {
            $productEntity->setVideoGenerated(
                new DateTime($productArray['video_generated'])
            );
        }

        $productGroupEntity = $this->amazonProductGroupFactory->buildFromName(
            $productArray['product_group']
        );
        $productEntity->setProductGroup(
            $productGroupEntity
        );
        try {
            $productEntity->binding      = $this->amazonBindingFactory->buildFromName(
                $productArray['binding']
            );
        } catch (Exception $exception) {
            // Do nothing.
        }
        try {
            $productEntity->setBrandEntity(
                $this->amazonBrandFactory->buildFromName(
                    $productArray['brand']
                )
            );
        } catch (Exception $exception) {
            // Do nothing.
        }
        $productEntity->listPrice    = $productArray['list_price'];

        $amazonProductFeatureArrays = $this->amazonProductFeatureTable->getArraysFromAsin($asin);
        foreach ($amazonProductFeatureArrays as $array) {
            $productEntity->features[] = $array['feature'];
        }

        $amazonProductImageArrays = $this->amazonProductImageTable->getArraysFromAsin($asin);
        foreach ($amazonProductImageArrays as $array) {
            $array['url'] = str_replace('http://ecx.', 'https://images-na.ssl-', $array['url']);
            if ($array['category'] == 'primary') {
                $productEntity->primaryImage = $this->imageFactory->buildFromArray(
                    $array
                );
            } else {
                $productEntity->variantImages[] = $this->imageFactory->buildFromArray(
                    $array
                );
            }
        }

        return $productEntity;
    }

    public function buildFromAsin(string $asin): AmazonEntity\Product
    {
        $productEntity = new AmazonEntity\Product();

        $productArray = $this->amazonProductTable->selectWhereAsin($asin);
        $productEntity->setAsin($productArray['asin'])
                      ->setProductId($productArray['product_id'])
                      ->setTitle($productArray['title']);

        if (isset($productArray['hi_res_images_retrieved'])) {
            $productEntity->setHiResImagesRetrieved(
                new DateTime($productArray['hi_res_images_retrieved'])
            );

            $hiResImages = [];
            $generator = $this->productHiResImageTable->selectWhereProductId(
                $productEntity->getProductId()
            );
            foreach ($generator as $array) {
                $imageEntity = new ImageEntity\Image();
                $imageEntity->setUrl($array['url']);
                $hiResImages[] = $imageEntity;
            }

            $productEntity->setHiResImages($hiResImages);
        }

        if (isset($productArray['video_generated'])) {
            $productEntity->setVideoGenerated(
                new DateTime($productArray['video_generated'])
            );
        }

        $productGroupEntity = $this->amazonProductGroupFactory->buildFromName(
            $productArray['product_group']
        );
        $productEntity->setProductGroup(
            $productGroupEntity
        );
        try {
            $productEntity->binding      = $this->amazonBindingFactory->buildFromName(
                $productArray['binding']
            );
        } catch (Exception $exception) {
            // Do nothing.
        }
        try {
            $productEntity->setBrandEntity(
                $this->amazonBrandFactory->buildFromName(
                    $productArray['brand']
                )
            );
        } catch (Exception $exception) {
            // Do nothing.
        }
        $productEntity->listPrice    = $productArray['list_price'];

        $amazonProductFeatureArrays = $this->amazonProductFeatureTable->getArraysFromAsin($asin);
        foreach ($amazonProductFeatureArrays as $array) {
            $productEntity->features[] = $array['feature'];
        }

        $amazonProductImageArrays = $this->amazonProductImageTable->getArraysFromAsin($asin);
        foreach ($amazonProductImageArrays as $array) {
            $array['url'] = str_replace('http://ecx.', 'https://images-na.ssl-', $array['url']);
            if ($array['category'] == 'primary') {
                $productEntity->primaryImage = $this->imageFactory->buildFromArray(
                    $array
                );
            } else {
                $productEntity->variantImages[] = $this->imageFactory->buildFromArray(
                    $array
                );
            }
        }

        $productEditorialReviewArrays = $this->amazonProductEditorialReviewTable->
            selectWhereAsin($asin);
        foreach ($productEditorialReviewArrays as $productEditorialReviewArray) {
            $productEntity->editorialReviews[]
                = $this->amazonProductEditorialReviewFactory->buildFromArray($productEditorialReviewArray);
        }

        return $productEntity;
    }

    /**
     * Build from product ID.
     *
     * @param int $productId
     * @return AmazonEntity\Product
     */
    public function buildFromProductId(int $productId)
    {
        $productEntity = new AmazonEntity\Product();

        $productArray             = $this->amazonProductTable->selectWhereProductId($productId);
        $productEntity->asin      = $productArray['asin'];
        $productEntity->productId = $productArray['product_id'];
        $productEntity->setTitle($productArray['title']);

        $productEntity->setProductGroup(
            $this->amazonProductGroupFactory->buildFromName(
                $productArray['product_group']
            )
        );

        try {
            $productEntity->setBindingEntity(
                $this->amazonBindingFactory->buildFromName(
                    $productArray['binding']
                )
            );
        } catch (Exception $exception) {
            // Do nothing.
        }

        try {
            $productEntity->setBrandEntity(
                $this->amazonBrandFactory->buildFromName(
                    $productArray['brand']
                )
            );
        } catch (Exception $exception) {
            // Do nothing.
        }
        $productEntity->listPrice    = $productArray['list_price'];

        $amazonProductFeatureArrays = $this->amazonProductFeatureTable->getArraysFromAsin(
            $productEntity->asin
        );
        foreach ($amazonProductFeatureArrays as $array) {
            $productEntity->features[] = $array['feature'];
        }

        $amazonProductImageArrays = $this->amazonProductImageTable->getArraysFromAsin(
            $productEntity->asin
        );
        foreach ($amazonProductImageArrays as $array) {
            $array['url'] = str_replace('http://ecx.', 'https://images-na.ssl-', $array['url']);
            if ($array['category'] == 'primary') {
                $productEntity->primaryImage = $this->imageFactory->buildFromArray(
                    $array
                );
            } else {
                $productEntity->variantImages[] = $this->imageFactory->buildFromArray(
                    $array
                );
            }
        }

        $productEditorialReviewArrays = $this->amazonProductEditorialReviewTable->
            selectWhereAsin($productEntity->asin);
        foreach ($productEditorialReviewArrays as $productEditorialReviewArray) {
            $productEntity->editorialReviews[]
                = $this->amazonProductEditorialReviewFactory->buildFromArray($productEditorialReviewArray);
        }

        return $productEntity;
    }
}
