<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Zend\Db\Adapter\Adapter;

class ProductFeature
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

    public function selectWhereAsin(string $asin): Generator
    {
        $sql = '
            SELECT `product_feature`.`asin`
                 , `product_feature`.`feature`
              FROM `product_feature`
             WHERE `asin` = ?
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute([$asin]) as $array) {
            yield $array;
        }
    }

    public function insert(
        string $asin,
        string $feature
    ): int {
        $sql = '
            INSERT
              INTO `product_feature` (`asin`, `feature`)
            VALUES (?, ?)
           ;
        ';
        $parameters = [
            $asin,
            $feature,
        ];
        return $this->adapter->query($sql)->execute($parameters)->getAffectedRows();
    }

    public function insertProductIfNotExists(AmazonEntity\Product $product)
    {
        return $this->insertWhereNotExists($product);
    }

    private function insertWhereNotExists(AmazonEntity\Product $product)
    {
        foreach ($product->features as $feature) {
            if (strlen($feature)) {
                $feature = substr($feature, 0, 255);
            }
            $feature = utf8_encode($feature);
            $sql = '
                INSERT
                  INTO `product_feature` (`asin`, `feature`)
                    SELECT ?, ?
                    FROM `product_feature`
                   WHERE NOT EXISTS (
                       SELECT `asin`
                         FROM `product_feature`
                        WHERE `asin` = ?
                          AND `feature` = ?
                      COLLATE utf8_general_ci
                   )
                   LIMIT 1
               ;
            ';
            $parameters = [
                $product->asin,
                $feature,
                $product->asin,
                $feature
            ];
            $this->adapter
                        ->query($sql, $parameters)
                        ->getGeneratedValue();
        }
    }
}
