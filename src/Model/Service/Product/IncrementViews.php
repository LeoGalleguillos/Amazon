<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Laminas\Db as LaminasDb;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class IncrementViews
{
    public function __construct(
        LaminasDb\Sql\Sql $sql
    ) {
        $this->sql = $sql;
    }

    public function incrementViews(AmazonEntity\Product $productEntity): bool
    {
        $update = $this->sql
            ->update('product')
            ->set([
                'views' => new \Laminas\Db\Sql\Expression('`views` + 1')
            ])
            ->where([
                'product_id' => $productEntity->getProductId()
            ]);

        return (bool) $this->sql
            ->prepareStatementForSqlObject($update)
            ->execute()
            ->getAffectedRows();
    }
}
