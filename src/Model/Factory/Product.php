<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
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
        AmazonTable\Product\Feature $amazonProductFeatureTable,
        AmazonTable\Product\Image $amazonProductImageTable
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
    }

    public function createFromMysql($asin)
    {
        $amazonProductEntity = new AmazonEntity\Product();

        $amazonProductArray = $this->amazonProductTable->getArrayFromAsin($asin);
        $amazonProductEntity->asin         = $amazonProductArray['asin'];
        $amazonProductEntity->title        = $amazonProductArray['title'];

        $amazonProductEntity->productGroup = $this->amazonProductGroupFactory->buildFromName(
            $amazonProductArray['product_group']
        );
        try {
            $amazonProductEntity->binding      = $this->amazonBindingFactory->buildFromName(
                $amazonProductArray['binding']
            );
        } catch (Exception $exception) {
        }
        try {
            $amazonProductEntity->brand      = $this->amazonBrandFactory->buildFromName(
                $amazonProductArray['brand']
            );
        } catch (Exception $exception) {
        }
        $amazonProductEntity->listPrice    = $amazonProductArray['list_price'];

        $amazonProductFeatureArrays = $this->amazonProductFeatureTable->getArraysFromAsin($asin);
        foreach ($amazonProductFeatureArrays as $array) {
            $amazonProductEntity->features[] = $array['feature'];
        }

        $amazonProductImageArrays = $this->amazonProductImageTable->getArraysFromAsin($asin);
        foreach ($amazonProductImageArrays as $array) {
            $array['url'] = str_replace('http://ecx.', 'https://images-na.ssl-', $array['url']);
            if ($array['category'] == 'primary') {
                $amazonProductEntity->primaryImage = $this->imageFactory->buildFromArray(
                    $array
                );
            } else {
                $amazonProductEntity->variantImages[] = $this->imageFactory->buildFromArray(
                    $array
                );
            }
        }

        $amazonProductEditorialReviewArrays = $this->amazonProductEditorialReviewTable->
            selectWhereAsin($asin);
        foreach ($amazonProductEditorialReviewArrays as $array) {
            $amazonProductEntity->editorialReviews[]
                = $this->amazonProductEditorialReviewFactory->buildFromArray($array);
        }

        return $amazonProductEntity;
    }

    public function createFromXml(SimpleXMLElement $xml)
    {
        /**
         * Maybe add:
         * A few more item attributes (color, genre, label, language,
         * manufacturer, publisher, studio, etc.)
         */

        $productEntity = new AmazonEntity\Product();

        $productEntity->asin         = (string) $xml->{'ASIN'};
        $productEntity->title        = (string) $xml->{'ItemAttributes'}->{'Title'};

        $productEntity->productGroup = $this->amazonProductGroupFactory->buildFromName(
            (string) $xml->{'ItemAttributes'}->{'ProductGroup'}
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
