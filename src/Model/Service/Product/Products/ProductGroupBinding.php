<?php
namespace LeoGalleguillos\Amazon\Model\Service\Product\Products;

use Generator;
use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class ProductGroupBinding
{
    public function __construct(
        AmazonFactory\Product $productFactory,
        AmazonTable\Product\ProductGroupBinding $productGroupBindingTable
    ) {
        $this->productFactory           = $productFactory;
        $this->productGroupBindingTable = $productGroupBindingTable;
    }

    public function getProductEntities(
        AmazonEntity\ProductGroup $productGroupEntity,
        AmazonEntity\Binding $bindingEntity
    ): Generator {
        $result = $this->productGroupBindingTable->selectWhereProductGroupBinding(
            $productGroupEntity->getName(),
            $bindingEntity->getName()
        );

        foreach ($result as $array) {
            yield $this->productFactory->buildFromArray($array);
        }
    }
}
