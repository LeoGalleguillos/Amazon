<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class ProductGroupIsValidModified
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

    public function selectAsinWhereProductGroupAndIsValidEquals1Limit10(
        string $productGroup
    ): Result {
        $sql = '
            SELECT `asin`
              FROM `product`
             WHERE `product_group` = ?
               AND `is_valid` = 1
             ORDER
                BY `modified` ASC
                 , `product_id` ASC
             LIMIT 10
                 ;
        ';
        $parameters = [
            $productGroup,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
