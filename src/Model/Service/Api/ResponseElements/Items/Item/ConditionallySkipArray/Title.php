<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\ResponseElements\Items\Item\ConditionallySkipArray;

class Title
{
    public function shouldArrayBeSkipped(
        array $itemArray
    ): bool {
        return (empty($itemArray['ItemInfo']['Title']['DisplayValue'])
            || (strlen($itemArray['ItemInfo']['Title']['DisplayValue']) > 255)
        );
    }
}
