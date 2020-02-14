<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pdo\Result;

class ProductEan
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

    public function getSelect(): string
    {
        return '
            SELECT `product_ean`.`product_id`
                 , `product_ean`.`ean`
        ';
    }

    public function insertIgnore(
        int $productId,
        string $ean
    ): Result {
        $sql = '
            INSERT IGNORE
              INTO `product_ean` (
                       `product_id`
                     , `ean`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $productId,
            $ean,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters);
    }
}
