<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

class SimilarRetrieved
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter = $adapter;
    }

    public function selectWhereAsin($asin)
    {
        $sql = '
            SELECT `product`.`similar_retrieved`
              FROM `product`
             WHERE `product`.`asin` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$asin])->current();
        return $row['similar_retrieved'];
    }

    public function updateToNowWhereAsin($asin)
    {
        $sql = '
            UPDATE `product`
               SET `product`.`similar_retrieved` = NOW()
             WHERE `product`.`asin` = ?
                 ;
        ';
        $this->adapter->query($sql, [$asin]);
    }
}
