<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

class NumberOfPages
{
    const MAX_NUMBER_OF_PAGES = 100;

    public function getNumberOfPages($numberOfResults): int
    {
        $numberOfPages = ceil($numberOfResults / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }
}
