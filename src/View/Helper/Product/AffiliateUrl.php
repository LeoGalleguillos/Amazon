<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Laminas\View\Helper\AbstractHelper;

class AffiliateUrl extends AbstractHelper
{
    public function __invoke(
        AmazonEntity\Product $productEntity,
        string $tag
    ) {
        return 'https://www.amazon.com/gp/product/'
            . $productEntity->asin
            . '?tag='
            . $tag;
    }
}
