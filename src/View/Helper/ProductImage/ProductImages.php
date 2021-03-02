<?php
namespace LeoGalleguillos\Amazon\View\Helper\ProductImage;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use Laminas\View\Helper\AbstractHelper;

class ProductImages extends AbstractHelper
{
    public function __construct(
        AmazonService\ProductImage\ProductImages $productImagesService
    ) {
        $this->productImagesService = $productImagesService;
    }

    public function __invoke(AmazonEntity\Product $productEntity)
    {
        return $this->productImagesService->getProductImages(
            $productEntity
        );
    }
}
