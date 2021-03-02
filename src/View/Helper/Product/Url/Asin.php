<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product\Url;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use Laminas\View\Helper\AbstractHelper;

class Asin extends AbstractHelper
{
    public function __construct(
        AmazonService\Product\Url\Asin $asinService
    ) {
        $this->asinService = $asinService;
    }

    public function __invoke(AmazonEntity\Product $productEntity)
    {
        return $this->asinService->getUrl(
            $productEntity
        );
    }
}
