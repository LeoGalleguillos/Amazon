<?php
namespace LeoGalleguillos\Amazon\Model\Service;

use LeoGalleguillos\Amazon\Model\Factory as AmazonFactory;
use LeoGalleguillos\Amazon\Model\Table as AmazonTable;

class Binding
{
    const MAX_NUMBER_OF_PAGES = 100;

    public function __construct(
        AmazonFactory\Product $amazonProductFactory,
        AmazonTable\Binding $amazonBindingTable
    ) {
        $this->amazonProductFactory = $amazonProductFactory;
        $this->amazonBindingTable   = $amazonBindingTable;
    }

    public function getNumberOfPages(int $numberOfProducts) : int
    {
        $numberOfPages = ceil($numberOfProducts / 100);
        return ($numberOfPages > self::MAX_NUMBER_OF_PAGES)
             ? self::MAX_NUMBER_OF_PAGES
             : $numberOfPages;
    }

    public function getNumberOfProducts(
        $productGroupName,
        $bindingName
    ) {
        return $this->amazonBindingTable->selectCountWhereProductGroupBinding(
            $productGroupName,
            $bindingName
        );
    }

    public function getProductEntities($productGroupName, $bindingName, int $page)
    {
        $asins = $this->amazonBindingTable->getAsins(
            $productGroupName,
            $bindingName,
            $page
        );

        $products = [];
        foreach ($asins as $asin) {
            $products[] = $this->amazonProductFactory->buildFromAsin($asin);
        }

        return $products;
    }

    public function insertIgnore($name)
    {
        if (empty($name)) {
            return;
        }
        $slug = preg_replace('/[^a-zA-Z0-9]/', '-', $name);
        $this->amazonBindingTable->insertIgnore($name, $slug);
    }
}
