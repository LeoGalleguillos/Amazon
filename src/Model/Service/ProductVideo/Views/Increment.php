<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\Views;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Increment
{
    public function __construct(
        AmazonTable\ProductVideo\ProductVideoId $productVideoIdTable
    ) {
        $this->productVideoIdTable = $productVideoIdTable;
    }

    public function incrementViews(AmazonEntity\ProductVideo $productVideoEntity): bool
    {
        return (bool) $this->productVideoIdTable->updateSetViewsToViewsPlusOneWhereProductVideoId(
            $productVideoEntity->getProductVideoId()
        );
    }
}
