<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;

class DownloadUrls
{
    public function __construct(
        AmazonService\Product\SourceCode $sourceCodeService,
        AmazonService\ProductHiResImage\ArrayFromSourceCode $arrayFromSourceCodeService,
        AmazonTable\ProductHiResImage $productHiResImageTable
    ) {
        $this->sourceCodeService          = $sourceCodeService;
        $this->arrayFromSourceCodeService = $arrayFromSourceCodeService;
        $this->productHiResImageTable     = $productHiResImageTable;
    }

    public function downloadUrls(AmazonEntity\Product $productEntity)
    {
        try {
            $hiResImagesRetrieved = $productEntity->getHiResImages();
            throw new Exception(
                'Hi-res images were already retrieved for this product.'
            );
        } catch (TypeError $typeError) {
            // Do nothing.
        }

        $sourceCode = $this->sourceCodeService->getSourceCode(
            $productEntity
        );

        $urls = $this->arrayFromSourceCodeService->getArrayFromSourceCode(
            $sourceCode
        );

        $order = 0;
        foreach ($urls as $url) {
            $order++;
            $this->productHiResImageTable->insert(
                $productEntity->getProductId(),
                $url,
                $order
            );
        }

        return (bool) $order;
    }
}
