<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;

class Generate
{
    public function __construct(
        AmazonService\ProductVideo\Command $commandService,
        AmazonService\ProductVideo\Generated $generatedService
    ) {
        $this->commandService   = $commandService;
        $this->generatedService = $generatedService;
    }

    public function generate(AmazonEntity\Product $productEntity)
    {
        if ($this->generatedService->wasGenerated($productEntity)
            || empty($productEntity->getHiResImages())
        ) {
            return;
        }

        $command = $this->commandService->getCommand($productEntity);
        exec($command);
    }
}
