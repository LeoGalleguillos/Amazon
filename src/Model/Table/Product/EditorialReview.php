<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Generator;
use LeoGalleguillos\Memcached\Model\Service\Memcached as MemcachedService;
use Zend\Db\Adapter\Adapter;

class EditorialReview
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function selectWhereAsin($asin): Generator
    {
        $sql = '
            SELECT `product_editorial_review`.`asin`
                 , `product_editorial_review`.`source`
                 , `product_editorial_review`.`content`
              FROM `product_editorial_review`
             WHERE `product_editorial_review`.`asin` = ?
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute([$asin]) as $array) {
            yield $array;
        }
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
