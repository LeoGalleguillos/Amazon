<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

class SourceCode
{
    public function getSourceCode(AmazonEntity\Product $productEntity): string
    {
        return file_get_contents(
            'https://www.amazon.com/dp/' . $productEntity->getAsin()
        );
    }
}
