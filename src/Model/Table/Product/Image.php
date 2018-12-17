<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
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
            SELECT `product_image`.`asin`
                 , `product_image`.`category`
                 , `product_image`.`url`
                 , `product_image`.`width`
                 , `product_image`.`height`
              FROM `product_image`
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

    public function insert(
        string $asin,
        string $category,
        string $url,
        int $width,
        int $height
    ): int {
        $sql = '
            INSERT
              INTO `product_image` (
                         `asin`
                       , `category`
                       , `url`
                       , `width`
                       , `height`
                   )
            VALUES (?, ?, ?, ?, ?)
                 ;
        ';
        $parameters = [
            $asin,
            $category,
            $url,
            $width,
            $height,
        ];
        $this->adapter->query($sql)->execute($parameters)->getAffectedRows();
    }

    public function insertProductIfNotExists(AmazonEntity\Product $product)
    {
        return $this->insertWhereNotExists($product);
    }

    private function insertWhereNotExists(AmazonEntity\Product $product)
    {
        $sql = '
            INSERT
              INTO `product_image` (
                         `asin`
                       , `category`
                       , `url`
                       , `width`
                       , `height`
                   )
                SELECT ?, ?, ?, ?, ?
                FROM `product_image`
               WHERE NOT EXISTS (
                   SELECT `asin`
                     FROM `product_image`
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
                $product->primaryImage->getUrl(),
                $product->primaryImage->getWidth(),
                $product->primaryImage->getHeight(),
                $product->asin,
                'primary',
                $product->primaryImage->getUrl(),
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }

        foreach ($product->variantImages as $imageEntity) {
            $parameters = [
                $product->asin,
                'variant',
                $imageEntity->getUrl(),
                $imageEntity->getWidth(),
                $imageEntity->getHeight(),
                $product->asin,
                'variant',
                $imageEntity->getUrl(),
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }
    }

    /**
     * Select width and height where ASIN and URL.
     *
     * @param string $asin
     * @param string $url
     * @return array
     */
    public function selectWidthAndHeightWhereAsinAndUrl(
        string $asin,
        string $url
    ) : array {
        $sql = '
            SELECT `product_image`.`width`
                 , `product_image`.`height`
              FROM `product_image`
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
            UPDATE `product_image`
               SET `product_image`.`width` = ?
                 , `product_image`.`height` = ?
             WHERE `product_image`.`asin` = ?
               AND `product_image`.`url` = ?
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
