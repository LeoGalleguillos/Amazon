<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use DateTime;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Laminas\View\Helper\AbstractHelper;
use TypeError;

class ModifiedOrCreated extends AbstractHelper
{
    public function __invoke(AmazonEntity\Product $productEntity): DateTime
    {
        try {
            return $productEntity->getModified();
        } catch (TypeError $typeError) {
            return $productEntity->getCreated();
        }
    }
}
