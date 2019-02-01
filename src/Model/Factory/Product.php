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
        AmazonFactory\Binding $bindingFactory,
        AmazonFactory\Brand $brandFactory,
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonFactory\ProductGroup $productGroupFactory,
        ImageFactory\Image $imageFactory,
        AmazonTable\BrowseNodeProduct $browseNodeProductTable,
        AmazonTable\Product $productTable,
        AmazonTable\ProductFeature $productFeatureTable,
        AmazonTable\ProductImage $productImageTable,
        AmazonTable\ProductHiResImage $productHiResImageTable
    ) {
        $this->bindingFactory         = $bindingFactory;
        $this->brandFactory           = $brandFactory;
        $this->browseNodeFactory      = $browseNodeFactory;
        $this->productGroupFactory    = $productGroupFactory;
        $this->imageFactory           = $imageFactory;
        $this->browseNodeProductTable = $browseNodeProductTable;
        $this->productTable           = $productTable;
        $this->productFeatureTable    = $productFeatureTable;
        $this->productImageTable      = $productImageTable;
        $this->productHiResImageTable = $productHiResImageTable;
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
            $this->productGroupFactory->buildFromArray([
                'name' => $productArray['product_group']
            ])
        );

        if (isset($productArray['binding'])) {
            $productEntity->binding = $productArray['binding'];
        }

        if (!empty($productArray['brand'])) {
            $productEntity->setBrandEntity(
                $this->brandFactory->buildFromName($productArray['brand'])
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
        Generator $browseNodeProductArrays,
        array $productArray,
        Generator $productFeatureArrays,
        Generator $productHiResImageArrays,
        Generator $productImageArrays
    ) {
        $productEntity = $this->buildFromArray($productArray);

        $browseNodeProductArrays = iterator_to_array($browseNodeProductArrays);
        if (!empty($browseNodeProductArrays)) {
            $browseNodeEntities = [];

            foreach ($browseNodeProductArrays as $browseNodeProductArray) {
                $browseNodeEntities[] = $this->browseNodeFactory->buildFromBrowseNodeId(
                    $browseNodeProductArray['browse_node_id']
                );
            }

            $productEntity->setBrowseNodes($browseNodeEntities);
        }

        $productEntity->setProductGroup(
            $this->productGroupFactory->buildFromName(
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
        $productArray = $this->productTable->selectWhereAsin($asin);

        return $this->buildFromProductId($productArray['product_id']);
    }

    public function buildFromProductId(int $productId)
    {
        $browseNodeProductArrays = $this->browseNodeProductTable->selectWhereProductId($productId);
        $productArray            = $this->productTable->selectWhereProductId($productId);
        $productFeatureArrays    = $this->productFeatureTable->selectWhereAsin($productArray['asin']);
        $productHiResImageArrays = $this->productHiResImageTable->selectWhereProductId($productId);
        $productImageArrays      = $this->productImageTable->selectWhereAsin($productArray['asin']);

        return $this->buildFromArraysAndGenerators(
            $browseNodeProductArrays,
            $productArray,
            $productFeatureArrays,
            $productHiResImageArrays,
            $productImageArrays
        );
    }
}
