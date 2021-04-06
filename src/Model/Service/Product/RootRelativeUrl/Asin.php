<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\RootRelativeUrl;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use MonthlyBasis\String\Model\Service as StringService;

class Asin
{
    public function __construct(
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function getRootRelativeUrl(
        AmazonEntity\Product $productEntity
    ): string {

        return '/watch/'
            . $productEntity->getAsin()
            . '/'
            . $this->urlFriendlyService->getUrlFriendly($productEntity->getTitle());
    }
}
