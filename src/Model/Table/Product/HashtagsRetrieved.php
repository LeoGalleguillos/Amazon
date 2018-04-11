<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Exception;
use Zend\Db\Adapter\Adapter;

class HashtagsRetrieved
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

    /**
     * @throws Exception
     */
    public function selectWhereProductId(int $productId) : string
    {
        $sql = '
            SELECT `product`.`hashtags_retrieved`
              FROM `product`
             WHERE `product`.`product_id` = ?
                 ;
        ';
        $row = $this->adapter->query($sql)->execute([$productId])->current();

        if (empty($row)) {
            throw new Exception('Hashtags have never been retrieved.');
        }

        return $row['similar_retrieved'];
    }

    public function updateWhereProductId(int $productId) : int
    {
        $sql = '
            UPDATE `product`
               SET `product`.`hashtags_retrieved` = UTC_TIMESTAMP()
             WHERE `product`.`product_id` = ?
                 ;
        ';
        return $this->adapter
                    ->query($sql)
                    ->execute([$productId])
                    ->getAffectedRows();
    }
}
