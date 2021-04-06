<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products\Search;

use MonthlyBasis\String\Model\Service as StringService;

class SanitizedQuery
{
    public function __construct(
        StringService\KeepFirstWords $keepFirstWordsService
    ) {
        $this->keepFirstWordsService = $keepFirstWordsService;
    }

    public function getSanitizedQuery(
        string $query
    ): string {
        $query = $this->keepFirstWordsService->keepFirstWords(
            $query,
            3
        );
        return str_replace('"', '', $query);
    }
}
