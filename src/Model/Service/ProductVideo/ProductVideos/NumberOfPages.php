<?php
namespace LeoGalleguillos\Amazon\Model\Service\ProductVideo\ProductVideos;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NumberOfPages
{
    public function __construct(
        AmazonTable\ProductVideo $productVideoTable
    ) {
        $this->productVideoTable = $productVideoTable;
    }

    public function getNumberOfPages(): int
    {
        return ceil($this->productVideoTable->selectCount() / 100);
    }
}
