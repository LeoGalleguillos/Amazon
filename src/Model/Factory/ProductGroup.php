<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    public function __construct(
        AmazonTable\ProductGroup $productGroupTable
    ) {
        $this->productGroupTable = $productGroupTable;
    }

    public function buildFromProductGroupId(int $productGroupId)
    {

    }

    public function buildFromName($name)
    {
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $amazonProductGroupEntity = new AmazonEntity\ProductGroup($name, $slug);
        return $amazonProductGroupEntity;
    }
}
