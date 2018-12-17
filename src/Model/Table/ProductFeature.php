<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class ProductFeature
{
    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * Construct.
     *
     * @param MemcachedService $memcached,
     * @param Adapter $adapter
     */
    public function __construct(
        MemcachedService $memcached,
        Adapter $adapter
    ) {
        $this->memcached = $memcached;
        $this->adapter   = $adapter;
    }

    public function getArraysFromAsin(string $asin)
    {
        $cacheKey = md5(__METHOD__ . $asin);
        if (null !== ($rows = $this->memcached->get($cacheKey))) {
            return $rows;
        }

        $sql = '
            SELECT `product_feature`.`asin`
                 , `product_feature`.`feature`
              FROM `product_feature`
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
        string $feature
    ): int {
        $sql = '
            INSERT
              INTO `product_feature` (`asin`, `feature`)
            VALUES (?, ?)
           ;
        ';
        $parameters = [
            $asin,
            $feature,
        ];
        return $this->adapter->query($sql)->execute($parameters)->getAffectedRows();
    }

    public function insertProductIfNotExists(AmazonEntity\Product $product)
    {
        return $this->insertWhereNotExists($product);
    }

    private function insertWhereNotExists(AmazonEntity\Product $product)
    {
        foreach ($product->features as $feature) {
            if (strlen($feature)) {
                $feature = substr($feature, 0, 255);
            }
            $feature = utf8_encode($feature);
            $sql = '
                INSERT
                  INTO `product_feature` (`asin`, `feature`)
                    SELECT ?, ?
                    FROM `product_feature`
                   WHERE NOT EXISTS (
                       SELECT `asin`
                         FROM `product_feature`
                        WHERE `asin` = ?
                          AND `feature` = ?
                      COLLATE utf8_general_ci
                   )
                   LIMIT 1
               ;
            ';
            $parameters = [
                $product->asin,
                $feature,
                $product->asin,
                $feature
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }
    }
}
