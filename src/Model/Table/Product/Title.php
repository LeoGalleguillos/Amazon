<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Exception\InvalidQueryException;

class Title
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
    public function selectProductIdWhereMatchAgainst(string $query): Result
    {
        $sql = '
            SELECT `product`.`product_id`
                 , MATCH(`product`.`title`) AGAINST (?) AS `score`
              FROM `product`
             WHERE MATCH(`product`.`title`) AGAINST (?)
             ORDER
                BY `score` DESC
             LIMIT 11
                 ;
        ';
        $parameters = [
            $query,
            $query,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
