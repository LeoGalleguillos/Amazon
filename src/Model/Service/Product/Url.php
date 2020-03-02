<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Url
{
    public function __construct(
        AmazonService\Product\Domain $domainService,
        AmazonService\Product\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->domainService          = $domainService;
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    public function getUrl(AmazonEntity\Product $productEntity) : string
    {
        return 'https://'
             . $this->domainService->getDomain($productEntity)
             . $this->rootRelativeUrlService->getRootRelativeUrl($productEntity);
    }
}
