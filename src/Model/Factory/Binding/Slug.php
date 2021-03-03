<?php
namespace LeoGalleguillos\Amazon\Model\Factory\Binding;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Slug
{
    public function __construct(
        AmazonTable\Binding $bindingTable
    ) {
        $this->bindingTable = $bindingTable;
    }

    public function buildFromSlug(string $slug): AmazonEntity\Binding
    {
        $name = $this->bindingTable->selectNameWhereSlugEquals($slug);

        return (new AmazonEntity\Binding)
            ->setName($name)
            ->setSlug($slug)
            ;
    }
}
