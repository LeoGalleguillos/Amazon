<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Product\Xml;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use SimpleXMLElement;
use Zend\Db\Adapter\Exception\InvalidQueryException;

class DownloadToMySql
{
    public function __construct(
        AmazonTable\Product $productTable,
        AmazonTable\ProductFeature $productFeatureTable,
        AmazonTable\ProductImage $productImageTable
    ) {
        $this->productTable        = $productTable;
        $this->productFeatureTable = $productFeatureTable;
        $this->productImageTable   = $productImageTable;
    }

    public function downloadToMySql(
        SimpleXMLElement $xml
    ) {
        $asin    = (string) $xml->{'ASIN'};
        $binding = $xml->{'ItemAttributes'}->{'Binding'} ?? null;
        $brand   = $xml->{'ItemAttributes'}->{'Brand'} ?? null;

        $listPriceCents = $xml->{'ItemAttributes'}->{'ListPrice'}->{'Amount'} ?? 0;
        $listPrice = $listPriceCents / 100;

        $productId = $this->productTable->insert(
            $asin,
            (string) $xml->{'ItemAttributes'}->{'Title'},
            (string) $xml->{'ItemAttributes'}->{'ProductGroup'},
            (string) $binding,
            (string) $brand,
            (float) $listPrice
        );

        if (!empty($xml->{'ItemAttributes'}->{'Feature'})) {
            foreach ($xml->{'ItemAttributes'}->{'Feature'} as $feature) {
                $this->productFeatureTable->insert(
                    $asin,
                    (string) $feature
                );
            }
        }

        if (!empty($xml->{'ImageSets'}->{'ImageSet'})) {
            foreach ($xml->{'ImageSets'}->{'ImageSet'} as $imageSet) {
                $category = (string) $imageSet['Category'];
                $url      = (string) $imageSet->{'LargeImage'}->{'URL'};
                $width    = (int) $imageSet->{'LargeImage'}->{'Width'};
                $height   = (int) $imageSet->{'LargeImage'}->{'Height'};

                $url = str_replace('http://ecx.', 'https://images-na.ssl-', $url);

                try {
                    $this->productImageTable->insert(
                        $asin,
                        $category,
                        $url,
                        $width,
                        $height
                    );
                } catch (InvalidQueryException $invalidQueryException) {
                    // Do nothing.
                }
            }
        }
    }
}
