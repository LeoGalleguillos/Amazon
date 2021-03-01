<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class ProductGroupBindingBrand
{
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\Product $productTable
    ) {
        $this->adapter      = $adapter;
        $this->productTable = $productTable;
    }

    public function selectWhereProductGroupBindingBrand(
        string $productGroup,
        string $binding,
        string $brand
    ): Result {
        $sql = $this->productTable->getSelect()
            . '
              FROM `product`
             WHERE `product`.`product_group` = ?
               AND `product`.`binding` = ?
               AND `product`.`brand` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT 0, 100
                 ;
        ';
        return $this->adapter->query($sql)->execute([$productGroup, $binding, $brand]);
    }

    /*

    The rest of these methods were imported from legacy code and can be
    re-implemented at some point.

    public function selectCountWhereProductGroupBindingBrand(
        $productGroup,
        $binding,
        $brand
    ) {
        $cacheKey = md5(__METHOD__ . $productGroup . $binding . $brand);
        if (false != ($count = $this->memcached->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `amazon_product`
             WHERE `amazon_product`.`product_group` = ?
               AND `amazon_product`.`binding` = ?
               AND `amazon_product`.`brand` = ?
                 ;
        ';
        $parameters = [
            $productGroup,
            $binding,
            $brand,
        ];
        $result = $this->adapter->query($sql, $parameters)->current();

        $count = (int) $result['count'];
        $this->memcached->setForDays($cacheKey, $count, 1);
        return $count;
    }

    public function selectAsinWhereProductGroupAndBrand($productGroup, $brand)
    {
        $cacheKey = md5(__METHOD__ . $productGroup . $brand);
        if (false != ($asins = $this->memcached->get($cacheKey))) {
            return $asins;
        }

        $sql = '
            SELECT `amazon_product`.`asin`
              FROM `amazon_product`
             WHERE `amazon_product`.`product_group` = ?
               AND `amazon_product`.`brand` = ?
             ORDER
                BY `amazon_product`.`modified` DESC
             LIMIT 0, 100
                 ;
        ';
        $results = $this->adapter->query($sql, [$productGroup, $brand]);

        $asins = [];
        foreach ($results as $row) {
            $asins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $asins, 1);
        return $asins;
    }

    public function selectNameWhereSlugEquals($slug)
    {
        $sql = '
            SELECT `amazon_brand`.`name`
              FROM `amazon_brand`
             WHERE `amazon_brand`.`slug` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$slug])->current();
        if (empty($row)) {
            throw new Exception('Brand slug not found.');
        }
        return $row['name'];
    }

    public function selectSlugWhereNameEquals($name)
    {
        if (empty($name)) {
            throw new Exception('Brand name not found.');
        }

        $cacheKey = md5(__METHOD__ . $name);
        if (false != ($slug = $this->memcached->get($cacheKey))) {
            return $slug;
        }

        $sql = '
            SELECT `amazon_brand`.`slug`
              FROM `amazon_brand`
             WHERE `amazon_brand`.`name` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$name])->current();
        if (empty($row)) {
            throw new Exception('Brand name not found.');
        }

        $slug = $row['slug'];
        $this->memcached->setForDays($cacheKey, $slug, 30);
        return $slug;
    }
     */
}
