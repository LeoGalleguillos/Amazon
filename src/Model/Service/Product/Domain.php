<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Domain
{
    public function __construct(
        AmazonService\Product\BrowseNode\First\Name $nameService,
        array $browseNodeNameDomain
    ) {
        $this->nameService          = $nameService;
        $this->browseNodeNameDomain = $browseNodeNameDomain;
    }

    public function getDomain(
        AmazonEntity\Product $productEntity
    ): string {
        try {
            $browseNodeName = $this->nameService->getFirstBrowseNodeName(
                $productEntity
            );
        } catch (Exception $exception) {
            return $this->browseNodeNameDomain['default'];
        }

        return $this->browseNodeNameDomain[$browseNodeName]
            ?? $this->browseNodeNameDomain['default'];
    }
}
