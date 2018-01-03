<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Website\Model\Entity\Amazon\Product as AmazonProductEntity;
use Zend\Db\Adapter\Adapter;

class Image
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(
        MemcachedService $memcached,
        Adapter $adapter
    ) {
        $this->memcached = $memcached;
        $this->adapter   = $adapter;
    }

    public function getArraysFromAsin($asin)
    {
        $cacheKey = md5(__METHOD__ . $asin);
        if (null !== ($rows = $this->memcached->get($cacheKey))) {
            return $rows;
        }

        $sql = '
            SELECT `amazon_product_image`.`asin`
                 , `amazon_product_image`.`category`
                 , `amazon_product_image`.`url`
                 , `amazon_product_image`.`width`
                 , `amazon_product_image`.`height`
              FROM `amazon_product_image`
             WHERE `asin` = ?
                 ;
        ';
        $results = $this->adapter->query($sql, [$asin]);

        $rows = [];
        foreach ($results as $row) {
            $rows[] = (array) $row;
        }

        $this->memcached->setForDays($cacheKey, $rows, 3);
        return $rows;
    }

    public function insertProductIfNotExists(AmazonProductEntity $product)
    {
        return $this->insertWhereNotExists($product);
    }

    private function insertWhereNotExists(AmazonProductEntity $product)
    {
        $sql = '
            INSERT
              INTO `amazon_product_image` (
                         `asin`
                       , `category`
                       , `url`
                       , `width`
                       , `height`
                   )
                SELECT ?, ?, ?, ?, ?
                FROM `amazon_product_image`
               WHERE NOT EXISTS (
                   SELECT `asin`
                     FROM `amazon_product_image`
                    WHERE `asin` = ?
                      AND `category` = ?
                      AND `url` = ?
               )
               LIMIT 1
           ;
        ';

        if ($product->primaryImage) {
            $parameters = [
                $product->asin,
                'primary',
                $product->primaryImage->url,
                $product->primaryImage->width,
                $product->primaryImage->height,
                $product->asin,
                'primary',
                $product->primaryImage->url,
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }

        foreach ($product->variantImages as $imageEntity) {
            $parameters = [
                $product->asin,
                'variant',
                $imageEntity->url,
                $imageEntity->width,
                $imageEntity->height,
                $product->asin,
                'variant',
                $imageEntity->url,
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }
    }

    public function selectWidthAndHeightWhereAsinAndUrl($asin, $url)
    {
        $sql = '
            SELECT `amazon_product_image`.`width`
                 , `amazon_product_image`.`height`
              FROM `amazon_product_image`
             WHERE `asin` = ?
               AND `url` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$asin, $url])->current();
        return [
            'width' => (int) $row['width'],
            'height' => (int) $row['height'],
        ];
    }

    public function updateSetWidthAndHeightWhereAsinAndUrl(
        $width,
        $height,
        $asin,
        $url
    ) {
        $sql = '
            UPDATE `amazon_product_image`
               SET `amazon_product_image`.`width` = ?
                 , `amazon_product_image`.`height` = ?
             WHERE `amazon_product_image`.`asin` = ?
               AND `amazon_product_image`.`url` = ?
                 ;
        ';
        $parameters = [
            $width,
            $height,
            $asin,
            $url
        ];
        $result = $this->adapter->query($sql, $parameters);
    }
}
