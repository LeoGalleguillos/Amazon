<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

class SimilarRetrievedCreated
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

    public function selectAsinWhereSimilarRetrievedIsNullOrderByCreatedDescLimit1(): string
    {
        $sql = '
            SELECT `product`.`asin`
              FROM `product`
             WHERE `product`.`similar_retrieved` IS NULL
             ORDER
                BY `product`.`created` DESC
             LIMIT 1
                 ;
        ';
        $array = $this->adapter->query($sql)->execute()->current();
        return $array['asin'];
    }
}
