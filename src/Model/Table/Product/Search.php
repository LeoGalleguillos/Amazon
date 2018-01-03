<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class Search
{
    const MAX_WORDS = 5;

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

    public function insertOnDuplicateKeyUpdate($asin, $title, $modified)
    {
        $sql = "
            INSERT
              INTO `amazon_product_search` (`asin`, `title`, `modified`)
            VALUES (?, ?, ?)
                ON
         DUPLICATE
               KEY
            UPDATE `asin` = VALUES(`asin`)
                 , `title` = VALUES(`title`)
                 , `modified` = VALUES(`modified`)
                 ;
        ";

        $parameters = [$asin, $title, $modified];
        $this->adapter->query($sql, $parameters);
    }

    public function selectCountWhereMatchTitleFeaturesAgainst($query)
    {
        $cacheKey = md5(__METHOD__ . $query);
        if (false != ($count = $this->memcached->get($cacheKey))) {
            return $count;
        }

        $query = $this->keepOnlyFirstWords($query);
        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `amazon_product_search`
             WHERE MATCH (`title`) AGAINST (?)
                 ;
        ';
        $row = $this->adapter->query($sql, [$query])->current();

        $count = (int) $row['count'];
        $this->memcached->setForDays($cacheKey, $count, 3);
        return $count;
    }

    public function selectAsinWhereMatchTitleFeaturesAgainst($query, $page)
    {
        $cacheKey = md5(__METHOD__ . $query . $page);
        if (false != ($asins = $this->memcached->get($cacheKey))) {
            return $asins;
        }

        $query = $this->keepOnlyFirstWords($query);
        $offset = (int) (($page - 1) * 100);
        $sql = "
            SELECT `asin`
              FROM `amazon_product_search`
             WHERE MATCH (`title`) AGAINST (?)
             LIMIT $offset, 100
                 ;
        ";
        $results = $this->adapter->query($sql, [$query]);

        $asins = [];

        foreach ($results as $row) {
            $asins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $asins, 3);
        return $asins;
    }

    /**
     * Select max modified.
     *
     * @return string
     */
    public function selectMaxModified()
    {
        $sql = '
            SELECT MAX(`modified`) AS `max_modified`
              FROM `amazon_product_search`
                 ;
        ';
        $row = $this->adapter->query($sql)->execute()->current();
        return $row['max_modified'];
    }

    private function keepOnlyFirstWords($query)
    {
        $words = explode(' ', $query);
        return implode(' ', array_slice($words, 0, self::MAX_WORDS));
    }
}
