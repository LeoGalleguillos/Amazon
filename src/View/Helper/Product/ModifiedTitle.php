<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Zend\View\Helper\AbstractHelper;

class ModifiedTitle extends AbstractHelper
{
    public function __invoke(AmazonEntity\Product $productEntity)
    {
        return 'wow' . $productEntity->title;
    }
}
