<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Brand;

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
        $array = $this->brandTable->selectWhereSlug($slug)->current();

        return (new AmazonEntity\Brand)
            ->setName($array['name'])
            ->setSlug($array['slug'])
            ;
    }
}
