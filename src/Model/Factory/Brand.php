<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Brand
{
    public function buildFromName(string $name): AmazonEntity\Brand
    {
        if (strlen($name) == 0) {
            throw new Exception('Unable to build because name is empty.');
        }

        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        return (new AmazonEntity\Brand($name, $slug))
            ->setName($name)
            ->setSlug($slug)
            ;
    }
}
