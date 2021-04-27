<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use MonthlyBasis\String\Model\Service as StringService;

class Brand
{
    public function __construct(
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function buildFromName(string $name): AmazonEntity\Brand
    {
        if (strlen($name) == 0) {
            throw new Exception('Unable to build because name is empty.');
        }

        $slug = $this->urlFriendlyService->getUrlFriendly($name);
        return (new AmazonEntity\Brand($name, $slug))
            ->setName($name)
            ->setSlug($slug)
            ;
    }
}
