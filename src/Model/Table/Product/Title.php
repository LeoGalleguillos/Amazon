<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Driver\Pdo\Result;
use Zend\Db\Adapter\Adapter;

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
