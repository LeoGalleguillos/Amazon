<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use ArrayObject;
use Generator;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use TypeError;
use Zend\Db\Adapter\Adapter;

class Product
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        MemcachedService $memcached,
        Adapter $adapter
    ) {
        $this->memcached = $memcached;
        $this->adapter   = $adapter;
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

    public function getSelect(): string
    {
        return '
            SELECT `product`.`product_id`
                 , `product`.`asin`
                 , `product`.`title`
                 , `product`.`product_group`
                 , `product`.`binding`
                 , `product`.`brand`
                 , `product`.`list_price`
                 , `product`.`modified`
                 , `product`.`hi_res_images_retrieved`
                 , `product`.`video_generated`
        ';
    }

    public function insert(
        string $asin,
        string $title,
        string $productGroup,
        string $binding = null,
        string $brand = null,
        float $listPrice
    ): int {
        $sql = '
            INSERT
              INTO `product` (
                       `asin`
                     , `title`
                     , `product_group`
                     , `binding`
                     , `brand`
                     , `list_price`
                   )
            VALUES (?, ?, ?, ?, ?, ?)
                 ;
        ';

        $parameters = [
            $asin,
            $title,
            $productGroup,
            $binding,
            $brand,
            $listPrice,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
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

    public function selectAsinWhereProductGroupAndSimilarRetrievedIsNull(
        string $productGroup
    ) {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`product_group` = ?
               AND `product`.`similar_retrieved` IS NULL
             LIMIT 1
                 ;
        ';
        $parameters = [
            $productGroup,
        ];
        $row = $this->adapter->query($sql, $parameters)->current();

        if (empty($row)) {
            return false;
        }

        return $row['asin'];
    }

    /**
     * @yield array
     */
    public function selectProductGroupGroupByProductGroup() : Generator
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
        foreach ($this->adapter->query($sql)->execute() as $row) {
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
     * @throws TypeError
     */
    public function selectWhereAsin(string $asin): array
    {
        $sql = $this->getSelect()
             . '
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        return $this->adapter->query($sql)->execute([$asin])->current();
    }

    /**
     * @throws TypeError
     *
     * @deprecated use AmazonTable\Product\ProductId::selectWhereProductId
     */
    public function selectWhereProductId(int $productId): array
    {
        $sql = $this->getSelect()
             . '
              FROM `product`
             WHERE `product`.`product_id` = ?
                 ;
        ';
        return $this->adapter->query($sql)->execute([$productId])->current();
    }
}
