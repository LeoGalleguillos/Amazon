<?php
namespace LeoGalleguillos\Amazon\View\Helper\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use LeoGalleguillos\Image\Model\Entity as ImageEntity;
use Zend\View\Helper\AbstractHelper;

class FirstImageEntity extends AbstractHelper
{
    public function __construct(
        AmazonService\Product\FirstImageEntity $firstImageEntityService
    ) {
        $this->firstImageEntityService = $firstImageEntityService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(
        AmazonEntity\Product $productEntity
    ) : ImageEntity\Image {
        try {
            return $this->firstImageEntityService->getFirstImageEntity(
                $productEntity
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
