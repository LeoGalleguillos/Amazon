<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductEan;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\Pdo\Result;

class ProductId
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\ProductEan $productEanTable
    ) {
        $this->adapter         = $adapter;
        $this->productEanTable = $productEanTable;
    }

    public function selectWhereProductId(
        int $productId
    ): Result {
        $sql = $this->productEanTable->getSelect()
            . '
              FROM `product_ean`
             WHERE `product_id` = ?
             ORDER
                BY `ean` ASC
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
