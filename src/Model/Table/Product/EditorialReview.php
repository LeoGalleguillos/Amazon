<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Website\Model\Entity\Amazon\Product as AmazonProductEntity;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class EditorialReview
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

    public function selectWhereAsin($asin)
    {
        $cacheKey = md5(__METHOD__ . $asin);
        if (null !== ($rows = $this->memcached->getItem($cacheKey))) {
            return $rows;
        }

        $sql = '
            SELECT `product_editorial_review`.`asin`
                 , `product_editorial_review`.`source`
                 , `product_editorial_review`.`content`
              FROM `product_editorial_review`
             WHERE `product_editorial_review`.`asin` = ?
                 ;
        ';
        $results = $this->adapter->query($sql, [$asin]);

        $rows = [];
        foreach ($results as $row) {
            $rows[] = (array) $row;
        }

        $this->memcached->setItem($cacheKey, $rows);
        return $rows;
    }

    public function insert($asin, $source, $content)
    {
        $sql = '
            INSERT
              INTO `product_editorial_review` (`asin`, `source`, `content`)
            VALUES (?, ?, ?)
                 ;
        ';
        $parameters = [
            $asin,
            $source,
            $content,
        ];
        $this->adapter->query($sql, $parameters);
    }
}
