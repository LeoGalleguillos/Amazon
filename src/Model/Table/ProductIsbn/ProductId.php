<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductIsbn;

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
        AmazonTable\ProductIsbn $productIsbnTable
    ) {
        $this->adapter          = $adapter;
        $this->productIsbnTable = $productIsbnTable;
    }

    public function selectWhereProductId(
        int $productId
    ): Result {
        $sql = $this->productIsbnTable->getSelect()
            . '
              FROM `product_isbn`
             WHERE `product_id` = ?
             ORDER
                BY `isbn` ASC
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
