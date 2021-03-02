<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class ProductUpc
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
            SELECT `product_upc`.`product_id`
                 , `product_upc`.`upc`
        ';
    }

    public function insertIgnore(
        int $productId,
        string $upc
    ): Result {
        $sql = '
            INSERT IGNORE
              INTO `product_upc` (
                       `product_id`
                     , `upc`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $productId,
            $upc,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters);
    }
}
