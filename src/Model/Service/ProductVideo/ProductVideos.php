<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Generator;
use LeoGalleguillos\Amazon\{
    Model\Factory as AmazonFactory,
    Model\Table as AmazonTable
};

class ProductVideos
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo\ProductVideoId $productVideoIdTable
    ) {
        $this->productVideoFactory = $productVideoFactory;
        $this->productVideoIdTable = $productVideoIdTable;
    }

    public function getProductVideos(int $page): Generator
    {
        $limitOffset   = ($page - 1) * 100;
        $limitRowCount = 100;

        $numberOfGaps = $limitOffset - $this->productVideoIdTable
            ->selectCountWhereProductVideoIdLessThanOrEqualTo(
                $limitOffset
            );
        $minProductVideoId = $limitOffset + 1 + $numberOfGaps;

        $generator = $this->productVideoIdTable->selectWhereProductVideoIdGreaterThanOrEqualToLimitRowCount(
            $minProductVideoId,
            $limitRowCount
        );
        foreach ($generator as $array) {
            yield $this->productVideoFactory->buildFromArray($array);
        }
    }
}
