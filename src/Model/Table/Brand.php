<?php
namespace LeoGalleguillos\Amazon\Model\Table;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Pdo\Result;

class Brand
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

    public function insert(
        string $name,
        string $slug
    ): Result {
        $sql = '
            INSERT
              INTO `brand` (
                       `name`
                     , `slug`
                   )
            VALUES (?, ?)
                 ;
        ';

        $parameters = [
            $name,
            $slug,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }

    public function selectWhereSlug(string $slug): Result
    {
        $sql = '
            SELECT `brand`.`brand_id`
                 , `brand`.`name`
                 , `brand`.`slug`
              FROM `brand`
             WHERE `brand`.`slug` = ?
                 ;
        ';
        $parameters = [
            $slug,
        ];
        return $this->adapter->query($sql)->execute($parameters);
    }
}
