<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use TypeError;

class ModifiedTitle
{
    public function getModifiedTitle(AmazonEntity\Product $product)
    {
        $title = $product->getTitle();

        // Remove (...) and [...]
        $title = preg_replace('/\(.*\)/', '', $title);
        $title = preg_replace('/\[.*\]/', '', $title);

        // Remove non-alphanumeric characters.
        $title = preg_replace('/[^\w ]/', '', $title);

        // Remove any words that are two characters or less.
        $title = preg_replace('/\b\w{1,2}\b/', ' ', $title);

        // Convert to array of words.
        $words = preg_split('/\s+/', $title);

        // Remove empty words.
        $words = array_filter($words);

        // Conditionally remove last words.
        while ($this->shouldLastWordBeRemoved($words)) {
            array_pop($words);
        }

        // Implode only first twenty words
        $title = implode(' ', array_slice($words, 0, 20));

        return $title;
    }

    protected function shouldLastWordBeRemoved(array $words)
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
