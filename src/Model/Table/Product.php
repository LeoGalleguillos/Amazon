<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Website\Model\Entity\Amazon\Product as AmazonProductEntity;
use Zend\Db\Adapter\Adapter;

class Product
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

    /**
     * @return array
     */
    public function getArrayFromAsin($asin)
    {
        $cacheKey = md5(__METHOD__ . $asin);
        if (false != ($array = $this->memcached->get($cacheKey))) {
            return $array;
        }

        $sql = '
            SELECT `product`.`asin`
                 , `product`.`title`
                 , `product`.`product_group`
                 , `product`.`binding`
                 , `product`.`brand`
                 , `product`.`list_price`
                 , `product`.`in_stock`
                 , `product`.`modified`
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        $array = (array) $this->adapter->query($sql, [$asin])->current();

        $this->memcached->setForDays($cacheKey, $array, 1);
        return $array;
    }

    public function getNewestAsins()
    {
        $cacheKey = md5(__METHOD__);
        if (false != ($newestAsins = $this->memcached->get($cacheKey))) {
            return $newestAsins;
        }

        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             ORDER
                BY `product`.`modified` DESC
             LIMIT 30
                 ;
        ';
        $results = $this->adapter->query($sql)->execute();

        $newestAsins = [];
        foreach ($results as $row) {
            $newestAsins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $newestAsins, 1);
        return $newestAsins;
    }

    private function insert(AmazonProductEntity $product)
    {
        $sql = '
            INSERT
              INTO `product` (`asin`, `title`, `product_group`, `list_price`)
            VALUES (?, ?, ?, ?)
                 ;
        ';
        $parameters = [
            $product->asin,
            substr($product->title, 0, 255),
            $product->productGroup,
            $product->listPrice,
        ];
        return $this->adapter
                    ->query($sql, $parameters)
                    ->getGeneratedValue();
    }

    public function insertProductIfNotExists(AmazonProductEntity $product)
    {
        return $this->insertWhereNotExists($product);
    }

    private function insertWhereNotExists(AmazonProductEntity $product)
    {
        $sql = '
            INSERT
              INTO `product` (`asin`, `title`, `product_group`, `binding`, `brand`, `list_price`)
                SELECT ?, ?, ?, ?, ?, ?
                FROM `product`
               WHERE NOT EXISTS (
                   SELECT `asin`
                     FROM `product`
                    WHERE `asin` = ?
               )
               LIMIT 1
           ;
        ';
        $parameters = [
            $product->asin,
            substr($product->title, 0, 255),
            $product->productGroup,
            $product->binding,
            $product->brand,
            $product->listPrice,
            $product->asin
        ];
        return $this->adapter
                    ->query($sql, $parameters)
                    ->getGeneratedValue();
    }

    public function isProductInTable($asin)
    {
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$asin])->current();
        return (bool) $row['count'];
    }

    public function selectAsinWhereSimilarRetrievedIsNull() : string
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`product_group` = "Jewelry"
               AND `product`.`similar_retrieved` IS NULL
             LIMIT 1
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return $row['asin'];
    }

    /**
     * @yield array
     */
    public function selectProductGroupGroupByProductGroup()
    {
        $sql = '
            SELECT `product`.`product_group`
                 , COUNT(*) as `count`
              FROM `product`
             GROUP
                BY `product`.`product_group`
             ORDER
                BY `count` DESC
                 ;
        ';
        $results = $this->adapter->query($sql)->execute();

        foreach ($results as $row) {
            yield $row;
        }
    }

    /**
     * @yield array
     */
    public function selectBindingGroupByBinding()
    {
        $sql = '
            SELECT `product`.`binding`
                 , COUNT(*) as `count`
              FROM `product`
             GROUP
                BY `product`.`binding`
             ORDER
                BY `count` DESC
                 ;
        ';
        $results = $this->adapter->query($sql)->execute();

        foreach ($results as $row) {
            yield $row;
        }
    }

    /**
     * @yield array
     */
    public function selectBrandGroupByBrand()
    {
        $sql = '
            SELECT `product`.`brand`
                 , COUNT(*) as `count`
              FROM `product`
             GROUP
                BY `product`.`brand`
             ORDER
                BY `count` DESC
                 ;
        ';
        $results = $this->adapter->query($sql)->execute();

        foreach ($results as $row) {
            yield $row;
        }
    }
}
