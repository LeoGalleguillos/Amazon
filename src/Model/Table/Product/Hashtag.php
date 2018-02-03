<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class Hashtag
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

    public function deleteWhereHashtagIdEquals($hashtagId)
    {
        $sql = '
            DELETE
              FROM `product_hashtag`
             WHERE `product_hashtag`.`hashtag_id` = ?
                 ;
        ';
        $this->adapter->query($sql, [$hashtagId]);
    }

    public function getAsinCount($hashtag)
    {
        $cacheKey = md5(__METHOD__ . $hashtag);
        if (false != ($count = $this->memcached->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product_hashtag`
              JOIN `hashtag`.`hashtag`
             USING (`hashtag_id`)
             WHERE `hashtag`.`hashtag`.`hashtag` = ?
                 ;
        ';
        $result = $this->adapter->query($sql, [$hashtag])->current();

        $count = (int) $result['count'];
        $this->memcached->setForDays($cacheKey, $count, 1);
        return $count;
    }

    public function getAsinsFromHashtag($hashtag, $page)
    {
        $cacheKey = md5(__METHOD__ . $hashtag . $page);
        if (false != ($asins = $this->memcached->get($cacheKey))) {
            return $asins;
        }

        $page = (int) $page;
        if ($page < 1) {
            $page = 1;
        }
        $offset = (int) (($page - 1) * 100);

        $sql = "
            SELECT `product_hashtag`.`asin`
              FROM `product_hashtag`
              JOIN `hashtag`.`hashtag`
             USING (`hashtag_id`)
              JOIN `product`
             USING (`asin`)
             WHERE `hashtag`.`hashtag`.`hashtag` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT $offset, 100
                 ;
        ";
        $results = $this->adapter->query($sql, [$hashtag]);

        $asins = [];
        foreach ($results as $row) {
            $asins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $asins, 5);
        return $asins;
    }

    public function getHashtagsFromAsin($asin)
    {
        $cacheKey = md5(__METHOD__ . $asin);
        if (false != ($hashtags = $this->memcached->get($cacheKey))) {
            return $hashtags;
        }

        $sql = '
            SELECT `hashtag`.`hashtag`.`hashtag`
              FROM `hashtag`.`hashtag`
              JOIN `product_hashtag`
             USING (`hashtag_id`)
             WHERE `product_hashtag`.`asin` = ?
             ORDER
                BY `hashtag`.`hashtag`.`hashtag` ASC
                 ;
        ';
        $results = $this->adapter->query($sql, [$asin]);

        $hashtags = [];
        foreach ($results as $row) {
            $hashtags[] = $row['hashtag'];
        }

        if ($hashtags) {
            $this->memcached->setForDays($cacheKey, $hashtags, 1);
        }
        return $hashtags;
    }

    public function insertIgnore($asin, $hastagId, $productGroup, $binding, $brand)
    {
        $sql = '
            INSERT
              INTO `product_hashtag` (
                       `asin`, `hashtag_id`
                   )
                SELECT ?, ?
                FROM `product_hashtag`
               WHERE NOT EXISTS (
                   SELECT `product_hashtag_id`
                     FROM `product_hashtag`
                    WHERE `asin` = ?
                      AND `hashtag_id` = ?
               )
               LIMIT 1
           ;
        ';

        $parameters = [
            $asin,
            $hastagId,
            $asin,
            $hastagId,
        ];
        $this->adapter
                ->query($sql, $parameters)
                ->getGeneratedValue();
    }
}
