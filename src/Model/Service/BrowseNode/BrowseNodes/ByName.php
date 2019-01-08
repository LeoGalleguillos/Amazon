<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNode\BrowseNodes;

use Generator;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ByName
{
    public function __construct(
        AmazonFactory\BrowseNode $browseNodeFactory,
        AmazonTable\BrowseNode $browseNodeTable
    ) {
        $this->browseNodeFactory = $browseNodeFactory;
        $this->browseNodeTable   = $browseNodeTable;
    }

    public function getByName(string $name): Generator
    {
        foreach ($this->browseNodeTable->selectWhereName($name) as $array) {
            yield $this->browseNodeFactory->buildFromArray($array);
        }
    }
}
