<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductVideos
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoTable   = $productVideoTable;
    }

    public function getProductVideos(int $page): Generator
    {
        $limitOffset   = ($page - 1) * 100;
        $limitRowCount = 100;

        $generator = $this->productVideoTable->select(
            $limitOffset,
            $limitRowCount
        );
        foreach ($generator as $array) {
            yield $this->productVideoFactory->buildFromArray($array);
        }
    }
}
