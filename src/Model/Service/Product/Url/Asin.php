<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Url;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Asin
{
    public function __construct(
        AmazonService\Product\Domain $domainService,
        AmazonService\Product\RootRelativeUrl\Asin $asinRootRelativeUrlService
    ) {
        $this->domainService              = $domainService;
        $this->asinRootRelativeUrlService = $asinRootRelativeUrlService;
    }

    public function getUrl(AmazonEntity\Product $productEntity): string
    {
        return 'https://'
            . $this->domainService->getDomain($productEntity)
            . $this->asinRootRelativeUrlService->getRootRelativeUrl($productEntity);
    }
}
