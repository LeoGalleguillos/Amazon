<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\Features;

use Laminas\Db\Adapter\Driver\Pdo\Connection;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\ProductFeature $productFeatureTable,
        Connection $connection
    ) {
        $this->productFeatureTable = $productFeatureTable;
        $this->connection          = $connection;
    }

    public function saveArrayToMySql(
        array $featuresArray,
        int $productId
    ) {
        $this->connection->beginTransaction();

        $this->productFeatureTable->deleteWhereProductId($productId);

        if (empty($featuresArray['DisplayValues'])) {
            $this->connection->commit();
            return;
        }

        foreach ($featuresArray['DisplayValues'] as $feature) {
            if (strlen($feature) > 255) {
                continue;
            }

            $this->productFeatureTable->insert(
                $productId,
                $feature
            );
        }

        $this->connection->commit();
    }
}
