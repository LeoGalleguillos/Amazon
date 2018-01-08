<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use Zend\View\Helper\AbstractHelper;

class ModifiedTitle extends AbstractHelper
{
    public function __construct(
        AmazonService\Product\ModifiedTitle $productModifiedTitleService
    ) {
        $this->productModifiedTitleService = $productModifiedTitleService;
    }

    public function getModifiedTitle(AmazonEntity\Product $productEntity)
    {
        return $this->productModifiedTitleService->getModifiedTitle(
            $productEntity
        );
    }
}
