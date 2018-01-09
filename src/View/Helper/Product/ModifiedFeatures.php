<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\View\Helper as AmazonHelper;
use Zend\View\Helper\AbstractHelper;

class ModifiedFeatures extends AbstractHelper
{
    public function __construct(
        AmazonHelper\Product\ModifiedFeature $modifiedFeatureHelper
    ) {
        $this->modifiedFeatureHelper = $modifiedFeatureHelper;
    }
    /**
     * Get modified features.
     */
    public function __invoke(AmazonEntity\Product $productEntity) : array
    {
        if (empty($productEntity->features)) {
            return [];
        }

        $modifiedFeatures = [];
        $numberOfFeatures = count($productEntity->features);

        for ($index = $numberOfFeatures - 1; $index >= 0; $index--) {
            $feature         = $productEntity->features[$index];
            $modifiedFeature = $this->modifiedFeatureHelper->__invoke($feature);

            if (trim($feature) != $modifiedFeature) {
                $modifiedFeatures[] = $modifiedFeature;
            }
        }

        return $modifiedFeatures;
    }
}
