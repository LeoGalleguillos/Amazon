<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use DateTime;
use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use LeoGalleguillos\Image\Model\Factory as ImageFactory;
use SimpleXMLElement;

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

    protected function buildFromArrays(
        array $productArray
    ) {
        // Coming soon.
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

    /**
     * Build from XML.
     *
     * @deprecated We should not be building product entities from XML.
     * @deprecated We should insert XML into MySQL first, then build from MySQL.
     *
     * @param SimpleXMLElement $xml
     * @return AmazonEntity\Product
     */
    public function buildFromXml(SimpleXMLElement $xml)
    {
        /**
         * Maybe add:
         * A few more item attributes (color, genre, label, language,
         * manufacturer, publisher, studio, etc.)
         */

        $productEntity = new AmazonEntity\Product();

        $productEntity->asin         = (string) $xml->{'ASIN'};
        $productEntity->setTitle((string) $xml->{'ItemAttributes'}->{'Title'});

        $productEntity->setProductGroup(
            $this->amazonProductGroupFactory->buildFromName(
                (string) $xml->{'ItemAttributes'}->{'ProductGroup'}
            )
        );
        try {
            $productEntity->binding  = $this->amazonBindingFactory->buildFromName(
                (string) $xml->{'ItemAttributes'}->{'Binding'}
            );
        } catch (Exception $exception) {
        }
        try {
            $productEntity->brand  = $this->amazonBrandFactory->buildFromName(
                (string) $xml->{'ItemAttributes'}->{'Brand'}
            );
        } catch (Exception $exception) {
        }

        // List price
        $listPriceCents = $xml->{'ItemAttributes'}->{'ListPrice'}->{'Amount'} ?? 0;
        $productEntity->listPrice = $listPriceCents / 100;

        // Images
        if (!empty($xml->{'ImageSets'}->{'ImageSet'})) {
            foreach ($xml->{'ImageSets'}->{'ImageSet'} as $imageSet) {
                $category = (string) $imageSet['Category'];
                $url      = (string) $imageSet->{'LargeImage'}->{'URL'};
                $width    = (int) $imageSet->{'LargeImage'}->{'Width'};
                $height   = (int) $imageSet->{'LargeImage'}->{'Height'};
                if ($category == 'primary') {
                    $url = str_replace('http://ecx.', 'https://images-na.ssl-', $url);
                    $productEntity->primaryImage = $this->imageFactory->buildFromArray(
                        [
                            'url'    => $url,
                            'width'  => $width,
                            'height' => $height,
                        ]
                    );
                } else {
                    $url = str_replace('http://ecx.', 'https://images-na.ssl-', $url);
                    $productEntity->variantImages[] = $this->imageFactory->buildFromArray(
                        [
                            'url'    => $url,
                            'width'  => $width,
                            'height' => $height,
                        ]
                    );
                }
            }
        }

        // Features
        $features = [];
        if (!empty($xml->{'ItemAttributes'}->{'Feature'})) {
            foreach ($xml->{'ItemAttributes'}->{'Feature'} as $feature) {
                $features[] = (string) $feature;
            }
        }
        $productEntity->features = $features;

        // Editorial reviews.
        if (!empty($xml->{'EditorialReviews'}->{'EditorialReview'})) {
            foreach ($xml->{'EditorialReviews'}->{'EditorialReview'} as $editorialReviewXml) {
                $productEntity->editorialReviews[]
                    = $this->amazonProductEditorialReviewFactory->buildFromXml($editorialReviewXml);
            }
        }

        return $productEntity;
    }
}
