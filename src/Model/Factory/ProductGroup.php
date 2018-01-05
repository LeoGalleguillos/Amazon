<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class ProductGroup
{
    public function buildFromName($name)
    {
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $amazonProductGroupEntity = new AmazonEntity\ProductGroup($name, $slug);
        return $amazonProductGroupEntity;
    }
}
