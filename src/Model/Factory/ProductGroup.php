<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;
use LeoGalleguillos\String\Model\Service as StringService;
use TypeError;

class ProductGroup
{
    public function __construct(
        AmazonTable\ProductGroup $productGroupTable,
        StringService\UrlFriendly $urlFriendlyService
    ) {
        $this->productGroupTable  = $productGroupTable;
        $this->urlFriendlyService = $urlFriendlyService;
    }

    public function buildFromArray(array $array): AmazonEntity\ProductGroup
    {
        $productGroupEntity = new AmazonEntity\ProductGroup();
        $productGroupEntity->setName(
            $array['name']
        );

        if (isset($array['product_group_id'])) {
            $productGroupEntity->setProductGroupId($array['product_group_id']);
        }

        if (isset($array['slug'])) {
            $productGroupEntity->setSlug($array['slug']);
        }

        if (isset($array['search_table'])) {
            $productGroupEntity->setSearchTable($array['search_table']);
        }

        return $productGroupEntity;
    }

    public function buildFromName(string $name): AmazonEntity\ProductGroup
    {
        try {
            return $this->buildFromArray(
                $this->productGroupTable->selectWhereName($name)
            );
        } catch (TypeError $typeError) {
            $nameUrlFriendly = $this->urlFriendlyService->getUrlFriendly(
                $name
            );
            $this->productGroupTable->insertIgnore(
                $name,
                $nameUrlFriendly,
                null
            );
            return $this->buildFromArray(
                $this->productGroupTable->selectWhereName($name)
            );
        }
    }

    public function buildFromProductGroupId(
        int $productGroupId
    ): AmazonEntity\ProductGroup {
        $arrayObject = $this->productGroupTable->selectWhereProductGroupId(
            $productGroupId
        );

        $productGroupEntity                 = new AmazonEntity\ProductGroup();
        $productGroupEntity->setProductGroupId($arrayObject['product_group_id']);
        $productGroupEntity->name           = $arrayObject['name'] ?? null;
        $productGroupEntity->slug           = $arrayObject['slug'] ?? null;

        if (!empty($arrayObject['search_table'])) {
            $productGroupEntity->setSearchTable($arrayObject['search_table']);
        }

        return $productGroupEntity;
    }
}
