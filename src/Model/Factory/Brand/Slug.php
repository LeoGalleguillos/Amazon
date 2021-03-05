<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Brand;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Slug
{
    public function __construct(
        AmazonTable\Brand $brandTable
    ) {
        $this->brandTable = $brandTable;
    }

    public function buildFromSlug(string $slug): AmazonEntity\Brand
    {
        $arrayOrFalse = $this->brandTable->selectWhereSlug($slug)->current();

        if (empty($arrayOrFalse)) {
            throw new Exception('Unable to build Brand because slug is not found.');
        }

        return (new AmazonEntity\Brand)
            ->setName($arrayOrFalse['name'])
            ->setSlug($arrayOrFalse['slug'])
            ;
    }
}
