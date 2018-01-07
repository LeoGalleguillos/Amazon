<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class ModifiedTitle
{
    public function getModifiedTitle(AmazonEntity\Product $product)
    {
        $title = $product->title;
        $brandRegularExpression = preg_quote($product->brand, '/');
        $title = preg_replace("/^$brandRegularExpression/i", '', $title);
        $title = preg_replace('/\s{2,}/', ' ', $title);
        $title = trim($title);
        return $title;
    }
}
