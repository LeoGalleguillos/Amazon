<?php
namespace LeoGalleguillos\Amazon\View\Helper\BrowseNode;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use Laminas\View\Helper\AbstractHelper;

class RootRelativeUrl extends AbstractHelper
{
    public function __construct(
        AmazonService\BrowseNode\RootRelativeUrl $rootRelativeUrlService
    ) {
        $this->rootRelativeUrlService = $rootRelativeUrlService;
    }

    public function __invoke(AmazonEntity\BrowseNode $browseNodeEntity)
    {
        return $this->rootRelativeUrlService->getRootRelativeUrl(
            $browseNodeEntity
        );
    }
}
