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

        // Remove any words that are two characters or less.
        $title = preg_replace('/\b\w{1,2}\b/', ' ', $title);

        // Keep only first nine words.
        $words = preg_split('/\s+/', $title);

        // Remove empty words.
        $words = array_filter($words);

        while ($this->shouldLastWordBeRemoved($words)) {
            array_pop($words);
        }

        $title = implode(' ', array_slice($words, 0, 9));

        return $title;
    }

    protected function shouldLastWordBeRemoved($words)
    {
        $lastWord = end($words);
        $wordsToRemove = [
            'and',
            'with',
        ];
        return in_array(
            strtolower($lastWord),
            $wordsToRemove
        );
    }
}
