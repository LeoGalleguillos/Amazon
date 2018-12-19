<?php
namespace LeoGalleguillos\Amazon\View\Helper\ProductVideo;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use Zend\View\Helper\AbstractHelper;

class SchemaOrgArray extends AbstractHelper
{
    public function __invoke(AmazonEntity\ProductVideo $productVideoEntity): array
    {
        return [];
    }
}
