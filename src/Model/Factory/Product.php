<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use DateTime;
use Exception;
use Generator;
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

        $productEntity->setProductGroup(
            $this->amazonProductGroupFactory->buildFromArray([
                'name' => $productArray['product_group']
            ])
        );

        if (isset($productArray['binding'])) {
            $productEntity->binding = $productArray['binding'];
        }

        if (!empty($productArray['brand'])) {
            $productEntity->setBrandEntity(
                $this->amazonBrandFactory->buildFromName($productArray['brand'])
            );
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

    protected function buildFromArraysAndGenerators(
        array $productArray,
        Generator $productFeatureArrays,
        Generator $productHiResImageArrays,
        Generator $productImageArrays
    ) {
        $productEntity = $this->buildFromArray($productArray);

        $productEntity->setProductGroup(
            $this->amazonProductGroupFactory->buildFromName(
                $productArray['product_group']
            )
        );

        foreach ($productFeatureArrays as $array) {
            $productEntity->features[] = $array['feature'];
        }

        foreach ($productHiResImageArrays as $productHiResImageArray) {
            $imageEntity = new ImageEntity\Image();
            $imageEntity->setUrl($productHiResImageArray['url']);
            $hiResImages[] = $imageEntity;
        }

        foreach ($productImageArrays as $array) {
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
        $productArray            = $this->amazonProductTable->selectWhereAsin($asin);
        $productFeatureArrays    = $this->amazonProductFeatureTable->selectWhereAsin($asin);
        $productImageArrays      = $this->amazonProductImageTable->selectWhereAsin($asin);
        $productHiResImageArrays = $this->productHiResImageTable->selectWhereProductId($productArray['product_id']);

        return $this->buildFromArraysAndGenerators(
            $productArray,
            $productFeatureArrays,
            $productImageArrays,
            $productHiResImageArrays
        );
    }

    public function buildFromProductId(int $productId)
    {
        $productArray            = $this->amazonProductTable->selectWhereProductId($productId);
        $productFeatureArrays    = $this->amazonProductFeatureTable->selectWhereAsin($productArray['asin']);
        $productImageArrays      = $this->amazonProductImageTable->selectWhereAsin($productArray['asin']);
        $productHiResImageArrays = $this->productHiResImageTable->selectWhereProductId($productId);

        return $this->buildFromArraysAndGenerators(
            $productArray,
            $productFeatureArrays,
            $productImageArrays,
            $productHiResImageArrays
        );
    }
}
