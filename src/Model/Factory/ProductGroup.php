<?php
namespace LeoGalleguillos\Amazon\Model\Factory;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroup
{
    public function __construct(
        AmazonTable\ProductGroup $productGroupTable
    ) {
        $this->productGroupTable = $productGroupTable;
    }

    /**
     * Build from array.
     *
     * @param array $array
     * @return AmazonEntity\ProductGroup
     */
    public function buildFromArray(array $array) : AmazonEntity\ProductGroup
    {
        $productGroupEntity                 = new AmazonEntity\ProductGroup();
        $productGroupEntity->setProductGroupId($array['product_group_id']);
        $productGroupEntity->name           = $array['name'] ?? null;
        $productGroupEntity->slug           = $array['slug'] ?? null;

        if (!empty($array['search_table'])) {
            $productGroupEntity->setSearchTable($array['search_table']);
        }

        return $productGroupEntity;
    }

    /**
     * Build from name.
     *
     * @param string $name
     * @return AmazonEntity\ProductGroup
     */
    public function buildFromName(string $name)
    {
        $arrayObject = $this->productGroupTable->selectWhereName(
            $name
        );

        $productGroupEntity                 = new AmazonEntity\ProductGroup();
        $productGroupEntity->productGroupId = $arrayObject['product_group_id'] ?? null;
        $productGroupEntity->name           = $arrayObject['name'] ?? null;
        $productGroupEntity->slug           = $arrayObject['slug'] ?? null;

        if (!empty($arrayObject['search_table'])) {
            $productGroupEntity->setSearchTable($arrayObject['search_table']);
        }

        return $productGroupEntity;
    }

    /**
     * Build from product group ID.
     *
     * @param int $productGroupId
     * @return AmazonEntity\ProductGroup
     */
    public function buildFromProductGroupId(
        int $productGroupId
    ) : AmazonEntity\ProductGroup {
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
