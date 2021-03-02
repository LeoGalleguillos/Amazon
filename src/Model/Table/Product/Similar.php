<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;

class Similar
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

    /**
     * Get similar ASINs.
     *
     * @param string $asin
     * @return string[]
     */
    public function getSimilarAsins($asin)
    {
        $sql = '
            SELECT `product_similar`.`similar_asin`
              FROM `product_similar`
             WHERE `product_similar`.`asin` = ?
                 ;
        ';
        $results = $this->adapter->query($sql, [$asin]);

        $asins = [];
        foreach ($results as $row) {
            $asins[] = $row['similar_asin'];
        }

        return $asins;
    }

    public function insertIgnore($asin, $similarAsin): int
    {
        $sql = '
            INSERT IGNORE
              INTO `product_similar`
                   (`asin`, `similar_asin`)
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $asin,
            $similarAsin,
        ];
        return $this->adapter
            ->query($sql)
            ->execute($parameters)
            ->getAffectedRows();
    }
}
