<?php
namespace LeoGalleguillos\Amazon\Model\Service\Brand;

use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class NameExists
{
    public function __construct(
        AmazonTable\Brand $brandTable
    ) {
        $this->brandTable = $brandTable;
    }

    public function doesNameExist(string $name): bool
    {
        return (bool) $this->brandTable->selectWhereName($name)->current();
    }
}
