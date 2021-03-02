<?php
namespace LeoGalleguillos\Amazon\Model\Table\Product;

use Laminas\Db\Adapter\Adapter;

class Review
{
    /**
     * @var Adapter
     */
    private $adapter;

    public function __construct(
        Adapter $adapter
    ) {
        $this->adapter   = $adapter;
    }

    public function insert($asin, $name, $rating, $review)
    {
        $sql = '
            INSERT
              INTO `product_review` (
                       `asin`, `name`, `rating`, `review`
                   )
            VALUES (?, ?, ?, ?)
           ;
        ';

        $parameters = [
            $asin,
            $name,
            $rating,
            $review,
        ];
        return $this->adapter
                ->query($sql, $parameters)
                ->getGeneratedValue();
    }
}
