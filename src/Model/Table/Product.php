<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use ArrayObject;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
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

    public function insertOnDuplicateKeyUpdate(AmazonEntity\Product $product)
    {
        $sql = '
            INSERT
              INTO `product` (`asin`, `title`, `product_group`, `binding`, `brand`, `list_price`)
            VALUES (?, ?, ?, ?, ?, ?)
                ON
         DUPLICATE
               KEY
            UPDATE `asin`  = VALUES(`asin`)
                 , `title` = VALUES(`title`)
                 , `product_group` = VALUES(`product_group`)
                 , `binding` = VALUES(`binding`)
                 , `brand` = VALUES(`brand`)
                 , `list_price` = VALUES(`list_price`)
                 ;
        ';
        $parameters = [
            $product->asin,
            substr($product->title, 0, 255),
            $product->productGroup,
            $product->binding,
            $product->brand,
            $product->listPrice,
        ];
        return (int) $this->adapter
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

    /**
     * @return ArrayObject
     */
    public function selectWhereProductId(int $productId)
    {
        $cacheKey = md5(__METHOD__ . $productId);
        if (false != ($array = $this->memcached->get($cacheKey))) {
            return $array;
        }

        $sql = '
            SELECT `product`.`product_id`
                 , `product`.`asin`
                 , `product`.`title`
                 , `product`.`product_group`
                 , `product`.`binding`
                 , `product`.`brand`
                 , `product`.`list_price`
                 , `product`.`modified`
              FROM `product`
             WHERE `product`.`product_id` = ?
                 ;
        ';
        $array = $this->adapter->query($sql, [$productId])->current();

        $this->memcached->setForDays($cacheKey, $array, 1);
        return $array;
    }
}
