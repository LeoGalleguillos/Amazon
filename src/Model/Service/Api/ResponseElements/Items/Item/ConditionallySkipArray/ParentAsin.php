<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

class ParentAsin
{
    public function shouldArrayBeSkipped(array $itemArray): bool
    {
        return !empty($itemArray['ParentASIN']);
    }
}
