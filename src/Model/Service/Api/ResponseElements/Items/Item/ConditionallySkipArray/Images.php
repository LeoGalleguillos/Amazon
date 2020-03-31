<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

class Images
{
    public function shouldArrayBeSkipped(
        array $itemArray
    ): bool {
        return (empty($itemArray['Images']['Primary'])
            || (empty($itemArray['Images']['Variants']))
        );
    }

}
