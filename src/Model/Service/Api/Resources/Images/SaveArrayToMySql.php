<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\Images;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class SaveArrayToMySql
{
    public function __construct(
        AmazonTable\ProductImage $productImageTable
    ) {
        $this->productImageTable = $productImageTable;
    }

    public function saveArrayToMySql(
        array $imagesArray,
        int $productId
    ) {
        $this->productImageTable->deleteWhereProductId($productId);

        if (isset($imagesArray['Primary'])) {
            $this->productImageTable->insertIgnore(
                $productId,
                'primary',
                $imagesArray['Primary']['Large']['URL'],
                $imagesArray['Primary']['Large']['Width'],
                $imagesArray['Primary']['Large']['Height']
            );
        }

        if (isset($imagesArray['Variants'])) {
            foreach ($imagesArray['Variants'] as $imageArray) {
                $this->productImageTable->insertIgnore(
                    $productId,
                    'variant',
                    $imageArray['Large']['URL'],
                    $imageArray['Large']['Width'],
                    $imageArray['Large']['Height']
                );
            }
        }
    }
}
