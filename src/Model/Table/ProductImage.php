<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Exception\InvalidQueryException;

class ProductImage
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

    public function selectWhereAsin($asin): Generator
    {
        $sql = '
            SELECT `product_image`.`asin`
                 , `product_image`.`category`
                 , `product_image`.`url`
                 , `product_image`.`width`
                 , `product_image`.`height`
              FROM `product_image`
             WHERE `asin` = ?
                 ;
        ';
        foreach ($this->adapter->query($sql)->execute([$asin]) as $array) {
            yield $array;
        }
    }

    /**
     * @throws InvalidQueryException
     */
    public function insert(
        string $asin,
        string $category,
        string $url,
        int $width,
        int $height
    ): int {
        $sql = '
            INSERT
              INTO `product_image` (
                         `asin`
                       , `category`
                       , `url`
                       , `width`
                       , `height`
                   )
            VALUES (?, ?, ?, ?, ?)
                 ;
        ';
        $parameters = [
            $asin,
            $category,
            $url,
            $width,
            $height,
        ];
        return $this->adapter->query($sql)->execute($parameters)->getAffectedRows();
    }

    /**
     * Select width and height where ASIN and URL.
     *
     * @param string $asin
     * @param string $url
     * @return array
     */
    public function selectWidthAndHeightWhereAsinAndUrl(
        string $asin,
        string $url
    ) : array {
        $sql = '
            SELECT `product_image`.`width`
                 , `product_image`.`height`
              FROM `product_image`
             WHERE `asin` = ?
               AND `url` = ?
                 ;
        ';
        $row = $this->adapter->query($sql, [$asin, $url])->current();
        return [
            'width' => (int) $row['width'],
            'height' => (int) $row['height'],
        ];
    }

    public function updateSetWidthAndHeightWhereAsinAndUrl(
        $width,
        $height,
        $asin,
        $url
    ) {
        $sql = '
            UPDATE `product_image`
               SET `product_image`.`width` = ?
                 , `product_image`.`height` = ?
             WHERE `product_image`.`asin` = ?
               AND `product_image`.`url` = ?
                 ;
        ';
        $parameters = [
            $width,
            $height,
            $asin,
            $url
        ];
        $result = $this->adapter->query($sql, $parameters);
    }
}
