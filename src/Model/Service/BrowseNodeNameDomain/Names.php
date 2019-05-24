<?php
namespace LeoGalleguillos\Amazon\Model\Service\BrowseNodeNameDomain;

class Names
{
    public function __construct(
        array $browseNodeNameDomains
    ) {
        $this->browseNodeNameDomains = $browseNodeNameDomains;
    }

    public function getNames(): array
    {
        unset($this->browseNodeNameDomains['default']);
        return array_keys($this->browseNodeNameDomains);
    }
}
