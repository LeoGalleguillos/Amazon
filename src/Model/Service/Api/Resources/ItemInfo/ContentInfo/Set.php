<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\ContentInfo;

use MonthlyBasis\ArrayModule\Service as ArrayModuleService;

class Set
{
    public function __construct(
        ArrayModuleService\Path\StringOrNull $stringOrNullService
    ) {
        $this->stringOrNullService = $stringOrNullService;
    }

    public function getSet(
        array $contentInfoArray
    ): array {
        return [
            'edition' => $this->getEdition($contentInfoArray),
        ];
    }

    /**
     * @return string|null
     */
    protected function getEdition(array $contentInfoArray)
    {
        return $this->stringOrNullService->getStringOrNull(
            ['Edition', 'DisplayValue'],
            $contentInfoArray,
            255
        );
    }
}
