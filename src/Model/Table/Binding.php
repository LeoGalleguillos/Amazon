<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Exception;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Laminas\Db\Adapter\Adapter;

class Binding
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

    public function insertIgnore($name, $slug)
    {
        $sql = '
            INSERT IGNORE
              INTO `binding` (`name`, `slug`)
            VALUES (?, ?)
                 ;
        ';
        $parameters = [
            $name,
            $slug,
        ];
        $this->adapter->query($sql, $parameters);
    }

    public function getAsins($productGroup, $binding, int $page)
    {
        $cacheKey = md5(__METHOD__ . $productGroup . $binding . $page);
        if (false != ($asins = $this->memcached->get($cacheKey))) {
            return $asins;
        }

        $offset = ($page - 1) * 100;
        $sql = "
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`product_group` = ?
               AND `product`.`binding` = ?
             ORDER
                BY `product`.`modified` DESC
             LIMIT $offset, 100
                 ;
        ";
        $results = $this->adapter->query($sql, [$productGroup, $binding]);

        $asins = [];

        foreach ($results as $row) {
            $asins[] = $row['asin'];
        }

        $this->memcached->setForDays($cacheKey, $asins, 5);
        return $asins;
    }

    /**
     * Count the number of products for a binding.
     *
     * @param string $productGroup Name of the product group.
     * @param string $binding      Name of the binding.
     * @return int
     */
    public function selectCountWhereProductGroupBinding(
        $productGroup,
        $binding
    ) {
        $cacheKey = md5(__METHOD__ . $productGroup . $binding);
        if (false != ($count = $this->memcached->get($cacheKey))) {
            return $count;
        }

        $sql = '
            SELECT COUNT(*) AS `count`
              FROM `product`
             WHERE `product`.`product_group` = ?
               AND `product`.`binding` = ?
                 ;
        ';
        $parameters = [
            $productGroup,
            $binding,
        ];
        $result = $this->adapter->query($sql, $parameters)->current();

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
            SELECT `binding`.`name`
              FROM `binding`
             WHERE `binding`.`slug` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$slug])->current();
        if (empty($row)) {
            throw new Exception('Binding slug not found.');
        }
        return $row['name'];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function selectSlugWhereNameEquals($name)
    {
        if (empty($name)) {
            throw new Exception('Binding name not found.');
        }

        $cacheKey = md5(__METHOD__ . $name);
        if (false != ($slug = $this->memcached->get($cacheKey))) {
            return $slug;
        }

        $sql = '
            SELECT `binding`.`slug`
              FROM `binding`
             WHERE `binding`.`name` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$name])->current();
        if (empty($row)) {
            throw new Exception('Binding name not found.');
        }

        $slug = $row['slug'];
        $this->memcached->setForDays($cacheKey, $slug, 30);
        return $slug;
    }
}
