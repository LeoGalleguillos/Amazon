<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Generate
{
    public function __construct(
        AmazonService\ProductVideo\Command $commandService
    ) {
        $this->commandService = $commandService;
    }

    public function generate(AmazonEntity\Product $productEntity): string
    {
        $command = $this->commandService->getCommand($productEntity);

        exec($command);
    }
}
