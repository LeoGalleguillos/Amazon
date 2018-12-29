<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

class Asin
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

    public function selectProductIdWhereAsin(
        string $asin
    ): int {
        $sql = '
            SELECT `product_id`
              FROM `product`
             WHERE `asin` = ?
                 ;
        ';
        $parameters = [
            $asin,
        ];
        return (int) $this->adapter->query($sql)->execute($parameters)->current();
    }
}
