<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pdo\Result;

class ProductSearch
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    /**
     * @throws InvalidQueryException Fulltext search can exceed max execution time.
     */
    public function selectProductIdWhereMatchAgainstLimit(
        string $query,
        int $limitOffset,
        int $limitRowCount
    ): Result {
        $sql = '
            SELECT `product_search`.`product_id`
                 , MATCH(`product_search`.`title_first_3_words`) AGAINST (?) AS `score`
              FROM `product_search`
             WHERE MATCH(`product_search`.`title_first_3_words`) AGAINST (?)
             ORDER
                BY `score` DESC
             LIMIT ?, ?
                 ;
        ';
        $parameters = [
            $query,
            $query,
            $limitOffset,
            $limitRowCount,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
