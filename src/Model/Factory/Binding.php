<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Binding
{
    public function buildFromName($name)
    {
        if (empty($name)) {
            throw new Exception('Unable to build because name is empty.');
        }

        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);

        return (new AmazonEntity\Binding)
            ->setName($name)
            ->setSlug($slug)
            ;
    }
}
