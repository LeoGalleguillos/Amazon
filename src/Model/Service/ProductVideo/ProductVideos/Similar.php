<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\String\Model\Service as StringService;

class Similar
{
    public function __construct(
        AmazonFactory\ProductVideo $productVideoFactory,
        AmazonTable\ProductVideo $productVideoTable,
        StringService\KeepFirstWords $keepFirstWordsService
    ) {
        $this->productVideoFactory   = $productVideoFactory;
        $this->productVideoTable     = $productVideoTable;
        $this->keepFirstWordsService = $keepFirstWordsService;
    }

    public function getSimilar(AmazonEntity\ProductVideo $productVideo): Generator
    {
        $query = $this->keepFirstWordsService->keepFirstWords(
            $productVideo->getTitle(),
            5
        );
        $query = str_replace('"', '', $query);

        $asins = $this->productVideoTable->selectAsinWhereMatchAgainst($query);
        foreach ($asins as $asin) {
            if ($asin == $productVideo->getAsin()) {
                continue;
            }
            yield $this->productVideoFactory->buildFromAsin($asin);
        }
    }
}
