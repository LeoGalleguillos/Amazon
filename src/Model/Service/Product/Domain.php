<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use TypeError;

class Domain
{
    public function __construct(
        AmazonService\Product\BrowseNodeProducts $browseNodeProductsService,
        array $browseNodeNameDomain
    ) {
        $this->browseNodeProductsService = $browseNodeProductsService;
        $this->browseNodeNameDomain      = $browseNodeNameDomain;
    }

    public function getDomain(
        AmazonEntity\Product $productEntity
    ): string {
        try {
            $browseNodeProducts = $this->browseNodeProductsService->getBrowseNodeProducts(
                $productEntity
            );
            $browseNodeName = $browseNodeProducts[0]->getBrowseNode()->getName();
        } catch (TypeError $typeError) {
            return $this->browseNodeNameDomain['default'];
        }

        return $this->browseNodeNameDomain[$browseNodeName]
            ?? $this->browseNodeNameDomain['default'];
    }
}
