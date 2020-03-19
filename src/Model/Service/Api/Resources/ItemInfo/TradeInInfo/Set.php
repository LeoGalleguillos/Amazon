<?php
namespace LeoGalleguillos\Amazon\Model\Service\Api\Resources\ItemInfo\TradeInInfo;

class Set
{
    public function getSet(
        array $tradeInInfoArray
    ): array {
        return [
            'is_eligible_for_trade_in' => isset($tradeInInfoArray['IsEligibleForTradeIn'])
                ? ((int) $tradeInInfoArray['IsEligibleForTradeIn'])
                : null,
            'trade_in_price' => isset($tradeInInfoArray['Price']['Amount'])
                ? ((float) $tradeInInfoArray['Price']['Amount'])
                : null,
        ];
    }
}
