<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class ModifiedTitle
{
    public function getModifiedTitle(AmazonEntity\Product $product)
    {
        $title = $product->title;

        // Remove brand.
        $brandRegularExpression = preg_quote($product->brand, '/');
        $title = preg_replace("/^$brandRegularExpression/i", '', $title);

        // Remove (...) and [...]
        $title = preg_replace('/\(.*\)?/', '', $title);
        $title = preg_replace('/\[.*\]?/', '', $title);

        // Remove non-alphanumeric characters.
        $title = preg_replace('/[^\w ]/', '', $title);

        // Keep only first nine words.
        $words = preg_split('/\s+/', $title);
        $title = implode(' ', array_slice($words, 0, 9));

        // Replace multiple spaces with one space.
        $title = preg_replace('/\s{2,}/', ' ', $title);

        // Trim.
        $title = trim($title);

        return $title;
    }
}
