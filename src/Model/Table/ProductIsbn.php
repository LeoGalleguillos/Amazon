<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class ProductIsbn
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
            SELECT `product_isbn`.`product_id`
                 , `product_isbn`.`isbn`
        ';
    }

    public function insertIgnore(
        int $productId,
        string $isbn
    ): Result {
        $sql = '
            INSERT IGNORE
              INTO `product_isbn` (
                       `product_id`
                     , `isbn`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $productId,
            $isbn,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters);
    }
}
