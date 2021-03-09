<?php
namespace LeoGalleguillos\Amazon\Model\Service\Brand;

use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\String\Model\Service as StringService;

class ConditionallyInsert
{
    public function __construct(
        AmazonService\Brand\NameExists $nameExistsService,
        AmazonTable\Brand $brandTable,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->nameExistsService  = $nameExistsService;
        $this->brandTable         = $brandTable;
        $this->urlFriendlyService = $urlFriendlyService;
    }

    /**
     * @return bool|int
     */
    public function conditionallyInsert(string $name)
    {
        if ($this->nameExistsService->doesNameExist($name)) {
            return false;
        }

        $result = $this->brandTable->insert(
            $name,
            $this->urlFriendlyService->getUrlFriendly($name)
        );

        return (int) $result->getGeneratedValue();
    }
}
