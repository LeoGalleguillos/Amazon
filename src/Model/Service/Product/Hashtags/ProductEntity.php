<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Hashtags;

use Error;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductEntity
{
    public function getHashtags(
        AmazonEntity\Product $productEntity
    ) : array {
        $words = $productEntity->getTitle();
        foreach ($productEntity->getFeatures() as $feature) {
            $words .= ' ' . $feature;
        }
        try {
            $words .= ' ' . $productEntity->getProductGroupEntity();
        } catch (Error $error) {
            // Do nothing.
        }
        try {
            $words .= ' ' . $productEntity->getBindingEntity();
        } catch (Error $error) {
            // Do nothing.
        }
        try {
            $words .= ' ' . $productEntity->getBrandEntity();
        } catch (Error $error) {
            // Do nothing.
        }
        $words = preg_replace('/\//', ' ', $words);
        $words = preg_replace('/[^A-Za-z0-9 ]/', '', $words);
        $words = strtolower($words);

        $words = preg_split('/\s+/', $words);

        $tags = [];
        foreach ($words as $word) {
            if (strlen($word) <= 2) {
                continue;
            }

            $wordsToSkip = $this->getWordsToSkip();
            if (in_array($word, $wordsToSkip)) {
                continue;
            }

            if (isset($tags[$word])) {
                $tags[$word]++;
            } else {
                $tags[$word] = 1;
            }
        }

        foreach ($tags as $tag => $count) {
            if ($count <= 1) {
                unset($tags[$tag]);
            }
        }

        $hashtags = array_keys($tags);
        sort($hashtags);

        return $hashtags;
    }

    protected function getWordsToSkip() : array
    {
        return [
            'a', 'all', 'also', 'an', 'and', 'any', 'are', 'as', 'at', 'be', 'can', 'either', 'for', 'from', 'has', 'how', 'in', 'is', 'its', 'not', 'of', 'or', 'our', 'such', 'that', 'the', 'their', 'this', 'than', 'they', 'through', 'to', 'way', 'what', 'when', 'where', 'which', 'why', 'will', 'with', 'yet', 'you', 'your'
        ];

    }
}
