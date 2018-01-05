<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use Exception;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;

class Brand
{
    public function buildFromName($name)
    {
        if (empty($name)) {
            throw new Exception('Unable to build brand because name is empty.');
        }

        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $amazonBrandEntity = new AmazonEntity\Brand($name, $slug);
        return $amazonBrandEntity;
    }
}
