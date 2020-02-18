<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductUpc;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\ProductUpc $productUpcTable
    ) {
        $this->adapter         = $adapter;
        $this->productUpcTable = $productUpcTable;
    }

    public function selectWhereProductId(
        int $productId
    ): Result {
        $sql = $this->productUpcTable->getSelect()
            . '
              FROM `product_upc`
             WHERE `product_id` = ?
             ORDER
                BY `upc` ASC
                 ;
        ';
        $parameters = [
            $productId,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters);
    }
}
