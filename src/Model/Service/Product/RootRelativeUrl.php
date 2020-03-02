<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\String\Model\Service as StringService;

class RootRelativeUrl
{
    public function __construct(
        AmazonService\Product\ModifiedTitle $modifiedTitleService,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->modifiedTitleService = $modifiedTitleService;
        $this->urlFriendlyService   = $urlFriendlyService;
    }

    public function getRootRelativeUrl(
        AmazonEntity\Product $productEntity
    ): string {
        $modifiedTitle = $this->modifiedTitleService->getModifiedTitle($productEntity);

        return '/products/'
             . (int) $productEntity->productId
             . '/'
             . $this->urlFriendlyService->getUrlFriendly($modifiedTitle);
    }
}
