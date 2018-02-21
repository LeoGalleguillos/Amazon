<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Exception;
use Generator;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class ProductGroup
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

    public function insertIgnore($name, $slug, $searchTable = null)
    {
        $sql = '
            INSERT IGNORE
              INTO `product_group` (`name`, `slug`, `search_table`)
            VALUES (?, ?, ?)
                 ;
        ';
        $parameters = [
            $name,
            $slug,
            $searchTable,
        ];
        return (int) $this->adapter->query($sql, $parameters)->getGeneratedValue();
    }

    public function getAsins(string $productGroup, int $page)
    {
        $cacheKey = md5(__METHOD__ . $productGroup . $page);
        if (false != ($asins = $this->memcached->get($cacheKey))) {
            return $asins;
        }

        $offset = ($page - 1) * 100;
        $sql = "
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`product_group` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT $offset, 100
                 ;
        ";
        $results = $this->adapter->query($sql, [$productGroup]);

        $asins = [];

        foreach ($results as $row) {
            $asins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $asins, 1);
        return $asins;
    }

    /**
     * Count the number of products for a given product group.
     *
     * @param string $productGroup Name of the product group.
     * @return int
     */
    public function selectCountWhereProductGroup($productGroup)
    {
        $cacheKey = md5(__METHOD__ . $productGroup);
        if (false != ($count = $this->memcached->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product`
             WHERE `product`.`product_group` = ?
                 ;
        ';
        $result = $this->adapter->query($sql, [$productGroup])->current();

        $count = (int) $result['count'];
        $this->memcached->setForDays($cacheKey, $count, 1);
        return $count;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function selectNameWhereSlugEquals($slug)
    {
        $sql = '
            SELECT `product_group`.`name`
              FROM `product_group`
             WHERE `product_group`.`slug` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$slug])->current();
        if (empty($row)) {
            throw new Exception('Product group slug not found.');
        }
        return $row['name'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function selectSlugWhereNameEquals($name)
    {
        $cacheKey = md5(__METHOD__ . $name);
        if (false != ($slug = $this->memcached->get($cacheKey))) {
            return $slug;
        }

        $sql = '
            SELECT `product_group`.`slug`
              FROM `product_group`
             WHERE `product_group`.`name` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$name])->current();
        if (empty($row)) {
            throw new Exception('Product group name not found.');
        }

        $slug = $row['slug'];
        $this->memcached->setForDays($cacheKey, $slug, 30);
        return $slug;
    }

    public function selectWhereProductGroupId(int $productGroupId)
    {
        $sql = '
            SELECT `product_group`.`product_group_id`
                 , `product_group`.`name`
                 , `product_group`.`slug`
                 , `product_group`.`search_table`
              FROM `product_group`
             WHERE `product_group`.`product_group_id` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$productGroupId])->current();
        if (empty($row)) {
            throw new Exception('Product group ID not found.');
        }
        return $row;
    }

    public function selectWhereName(string $name)
    {
        $sql = '
            SELECT `product_group`.`product_group_id`
                 , `product_group`.`name`
                 , `product_group`.`slug`
                 , `product_group`.`search_table`
              FROM `product_group`
             WHERE `product_group`.`name` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$name])->current();
        if (empty($row)) {
            throw new Exception('Product group ID not found.');
        }
        return $row;
    }

    /**
     * Select where search_table is not null.
     *
     * @yield array
     */
    public function selectWhereSearchTableIsNotNull() : Generator
    {
        $sql = '
            SELECT `product_group`.`product_group_id`
                 , `product_group`.`name`
                 , `product_group`.`slug`
                 , `product_group`.`search_table`
              FROM `product_group`
             WHERE `product_group`.`search_table` IS NOT NULL
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute() as $row) {
            yield $row;
        }
    }
}
