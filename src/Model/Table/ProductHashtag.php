<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class ProductHashtag
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

    public function selectHashtagWhereAsin(string $asin)
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

    public function insertIgnore(
        int $productId,
        int $hashtagId,
        int $productGroupId,
        int $bindingId,
        int $brandId
    ) {
        $sql = '
            INSERT IGNORE
              INTO `product_hashtag` (
                       `product_id`,
                       `hashtag_id`,
                       `product_group_id`,
                       `binding_id`,
                       `brand_id`
                   )
            VALUES (?, ?, ?, ?, ?)
                 ;
        ';

        $parameters = [
            $productId,
            $hashtagId,
            $productGroupId,
            $bindingId,
            $brandId,
        ];
        return $this->adapter
                    ->query($sql)
                    ->execute($parameters)
                    ->getGeneratedValue();
    }
}
