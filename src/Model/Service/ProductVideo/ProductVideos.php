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

    public function getProductVideos(): Generator
    {
        foreach ($this->productVideoTable->select() as $array) {
            yield $this->productVideoFactory->buildFromArray($array);
        }
    }
}
