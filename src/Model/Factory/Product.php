<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use DateTime;
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
        AmazonFactory\ProductGroup $productGroupFactory,
        ImageFactory\Image $imageFactory,
        AmazonTable\Product $productTable,
        AmazonTable\Product\Asin $asinTable,
        AmazonTable\ProductEan\ProductId $productEanProductIdTable,
        AmazonTable\ProductFeature $productFeatureTable,
        AmazonTable\ProductImage $productImageTable,
        AmazonTable\ProductIsbn\ProductId $productIsbnProductIdTable,
        AmazonTable\ProductUpc\ProductId $productUpcProductIdTable
    ) {
        $this->bindingFactory            = $bindingFactory;
        $this->brandFactory              = $brandFactory;
        $this->productGroupFactory       = $productGroupFactory;
        $this->imageFactory              = $imageFactory;
        $this->productTable              = $productTable;
        $this->asinTable                 = $asinTable;
        $this->productEanProductIdTable  = $productEanProductIdTable;
        $this->productFeatureTable       = $productFeatureTable;
        $this->productImageTable         = $productImageTable;
        $this->productIsbnProductIdTable = $productIsbnProductIdTable;
        $this->productUpcProductIdTable  = $productUpcProductIdTable;
    }

    public function buildFromArray(
        array $productArray
    ): AmazonEntity\Product {
        $productEntity = (new AmazonEntity\Product())
            ->setAsin($productArray['asin'])
            ->setProductId($productArray['product_id'])
            ;

        if (isset($productArray['product_group'])) {
            $productEntity->setProductGroup(
                $this->productGroupFactory->buildFromArray([
                    'name' => $productArray['product_group']
                ])
            );
        }

        if (isset($productArray['binding'])) {
            $productEntity->binding = $productArray['binding'];
        }

        if (!empty($productArray['brand'])) {
            $productEntity->setBrandEntity(
                $this->brandFactory->buildFromName($productArray['brand'])
            );
        }

        if (isset($productArray['color'])) {
            $productEntity->setColor(
                $productArray['color']
            );
        }

        $result = $this->productEanProductIdTable->selectWhereProductId(
            $productArray['product_id']
        );
        $eans = array_column(iterator_to_array($result), 'ean');
        if (!empty($eans)) {
            $productEntity->setEans($eans);
        }

        $productFeatureArrays = $this->productFeatureTable->selectWhereAsin($productArray['asin']);
        foreach ($productFeatureArrays as $array) {
            $productEntity->features[] = $array['feature'];
        }

        if (isset($productArray['height_units'])) {
            $productEntity->setHeightUnits(
                $productArray['height_units']
            );
        }

        if (isset($productArray['height_value'])) {
            $productEntity->setHeightValue(
                $productArray['height_value']
            );
        }

        if (isset($productArray['length_units'])) {
            $productEntity->setLengthUnits(
                $productArray['length_units']
            );
        }

        if (isset($productArray['length_value'])) {
            $productEntity->setLengthValue(
                $productArray['length_value']
            );
        }

        if (isset($productArray['list_price'])) {
            $productEntity->setListPrice(
                (float) $productArray['list_price']
            );
        }

        if (isset($productArray['is_adult_product'])) {
            $productEntity->setIsAdultProduct(
                $productArray['is_adult_product']
            );
        }

        if (isset($productArray['released'])) {
            $productEntity->setReleased(
                new DateTime($productArray['released'])
            );
        }

        if (isset($productArray['size'])) {
            $productEntity->setSize(
                $productArray['size']
            );
        }

        if (isset($productArray['title'])) {
            $productEntity->setTitle(
                $productArray['title']
            );
        }

        if (isset($productArray['unit_count'])) {
            $productEntity->setUnitCount(
                $productArray['unit_count']
            );
        }

        $result = $this->productUpcProductIdTable->selectWhereProductId(
            $productArray['product_id']
        );
        $upcs = array_column(iterator_to_array($result), 'upc');
        if (!empty($upcs)) {
            $productEntity->setUpcs($upcs);
        }

        if (isset($productArray['video_generated'])) {
            $productEntity->setVideoGenerated(
                new DateTime($productArray['video_generated'])
            );
        }

        if (isset($productArray['weight_units'])) {
            $productEntity->setWeightUnits(
                $productArray['weight_units']
            );
        }

        if (isset($productArray['weight_value'])) {
            $productEntity->setWeightValue(
                $productArray['weight_value']
            );
        }

        if (isset($productArray['width_units'])) {
            $productEntity->setWidthUnits(
                $productArray['width_units']
            );
        }

        if (isset($productArray['width_value'])) {
            $productEntity->setWidthValue(
                $productArray['width_value']
            );
        }

        $productImageArrays = $this->productImageTable->selectWhereAsin($productArray['asin']);
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
        return $this->buildFromArray(
            $this->asinTable->selectWhereAsin($asin)
        );
    }

    public function buildFromProductId(int $productId): AmazonEntity\Product
    {
        return $this->buildFromArray(
            $this->productTable->selectWhereProductId($productId)
        );
    }
}
