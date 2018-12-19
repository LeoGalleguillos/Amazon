<?php
namespace LeoGalleguillos\Amazon\Model\Table\ProductVideo;

use Zend\Db\Adapter\Adapter;

class DurationMilliseconds
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

    public function updateWhereProductId(
        int $durationMilliseconds,
        int $productId
    ): int {
        $sql = '
            UPDATE `product_video`
               SET `duration_milliseconds` = ?
             WHERE `product_id` = ?
        ';
        $parameters = [
            $durationMilliseconds,
            $productId,
        ];
        return (int) $this->adapter
                          ->query($sql)
                          ->execute($parameters)
                          ->getAffectedRows();
    }
}
