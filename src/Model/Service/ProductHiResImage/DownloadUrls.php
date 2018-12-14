<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductHiResImage;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use TypeError;
use Zend\Db\Adapter\Exception\InvalidQueryException;

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
            return;
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
            try {
                $this->productHiResImageTable->insert(
                    $productEntity->getProductId(),
                    $url,
                    $order
                );
            } catch (InvalidQueryException $invalidQueryException) {
                // Do nothing.
            }
        }

        return (bool) $order;
    }
}
