<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Zend\Db\Adapter\Adapter;

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

    public function insertIfNotExists($asin, $similarAsin)
    {
        return $this->insertWhereNotExists($asin, $similarAsin);
    }

    private function insertWhereNotExists($asin, $similarAsin)
    {
        $sql = '
            INSERT
              INTO `product_similar` (`asin`, `similar_asin`)
                SELECT ?, ?
                FROM `product_similar`
               WHERE NOT EXISTS (
                   SELECT `asin`
                     FROM `product_similar`
                    WHERE `asin` = ?
                      AND `similar_asin` = ?
               )
               LIMIT 1
           ;
        ';

        $parameters = [
            $asin,
            $similarAsin,
            $asin,
            $similarAsin,
        ];
        $this->adapter
                ->query($sql, $parameters)
                ->getGeneratedValue();
    }
}
