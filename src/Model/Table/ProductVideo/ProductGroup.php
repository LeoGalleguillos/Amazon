<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

use Generator;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use Zend\Db\Adapter\Adapter;

class ProductGroup
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->adapter           = $adapter;
        $this->productVideoTable = $productVideoTable;
    }

    /**
     * @yield array
     */
    public function selectWhereProductGroup(
        string $productGroup
    ): Generator {
        $sql = $this->productVideoTable->getSelect()
             . '
              FROM `product_video`

              JOIN `product`
             USING (`product_id`)

             WHERE `product`.`product_group` = ?
        ';
        $parameters = [
            $productGroup,
        ];
        foreach ($this->adapter->query($sql)->execute($parameters) as $array) {
            yield $array;
        }
    }
}
