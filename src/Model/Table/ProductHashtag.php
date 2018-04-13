<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class ProductHashtag
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

    public function selectHashtagWhereProductId(int $productId) : array
    {
        $cacheKey = md5(__METHOD__ . $productId);
        if (false != ($hashtags = $this->memcached->get($cacheKey))) {
            return $hashtags;
        }

        $sql = '
            SELECT `hashtag`.`hashtag`.`hashtag`
              FROM `hashtag`.`hashtag`
              JOIN `product_hashtag`
             USING (`hashtag_id`)
             WHERE `product_hashtag`.`product_id` = ?
             ORDER
                BY `hashtag`.`hashtag`.`hashtag` ASC
                 ;
        ';
        $results = $this->adapter->query($sql)->execute([$productId]);

        $hashtags = [];
        foreach ($results as $row) {
            $hashtags[] = $row['hashtag'];
        }

        if ($hashtags) {
            $this->memcached->setForDays($cacheKey, $hashtags, 3);
        }
        return $hashtags;
    }

    public function insertIgnore(
        int $productId,
        int $hashtagId,
        int $productGroupId = null,
        int $bindingId = null,
        int $brandId = null
    ) :int {
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
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getGeneratedValue();
    }

    public function selectProductIdWhereHashtagIdProductGroupId(
        int $hashtagId,
        int $productGroupId
    ) : Generator {
        $sql = '
            SELECT `product_hashtag`.`product_id`
              FROM `product_hashtag`
             WHERE `product_hashtag`.`hashtag_id` = ?
               AND `product_hashtag`.`product_group_id` = ?
             ORDER
                BY `product_hashtag`.`product_id` DESC
             LIMIT 0, 100
                 ;
        ';
        $parameters = [
            $hashtagId,
            $productGroupId,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $row) {
            yield $row['product_id'];
        }
    }
}
