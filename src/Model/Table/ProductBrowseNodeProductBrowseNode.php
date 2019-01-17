<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Exception;
use Zend\Db\Adapter\Adapter;

class ProductBrowseNodeProductBrowseNode
{
    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function selectCountWhereProductVideoGeneratedIsNullAndBrowseNodeNameEquals(
        string $browseNodeName
    ): int {
        $sql = '
            select count(*) AS `count`

              from product

              join browse_node_product
             using (product_id)

              join browse_node
             using (browse_node_id)

             where product.video_generated is null
               and browse_node.name = ?
                 ;
        ';
        $parameters = [
            $browseNodeName,
        ];
        $array = $this->adapter->query($sql)->execute($parameters)->current();
        return (int) $array['count'];
    }
}
