<?php
namespace LeoGalleguillos\AmazonTest\Model\Service\Product;

use LeoGalleguillos\Amazon\Model\Entity as AmazonEntity;
use LeoGalleguillos\Amazon\Model\Service as AmazonService;
use PHPUnit\Framework\TestCase;
use TypeError;

class DomainTest extends TestCase
{
    protected function setUp()
    {
        $this->browseNodeProductsServiceMock = $this->createMock(
            AmazonService\Product\BrowseNodeProducts::class
        );
        $this->browseNodeNameDomainArray = [
            'default' => 'www.example.com',
            'Rich'    => 'product.tube',
            'Wealth'  => 'www.monthlybasis.com',
        ];

        $this->domainService = new AmazonService\Product\Domain(
            $this->browseNodeProductsServiceMock,
            $this->browseNodeNameDomainArray
        );
    }

    public function testGetUrl_BrowseNodeProductsIsEmpty_ReturnDefaultDomain()
    {
        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['default'],
            $this->domainService->getDomain($productEntity)
        );
    }

    public function testGetUrl_BrowseNodeNameExistsInArray_ReturnNonDefaultDomain()
    {
        $browseNodeProducts = [
            $this->getBrowseNodeProductWithBrowseNodeName('Wealth'),
            $this->getBrowseNodeProductWithBrowseNodeName('Rich'),
        ];
        $this->browseNodeProductsServiceMock
            ->method('getBrowseNodeProducts')
            ->willReturn($browseNodeProducts);

        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['Wealth'],
            $this->domainService->getDomain($productEntity)
        );
    }

    public function testGetUrl_BrowseNodeNameDoesNotExistInArray_ReturnDefaultDomain()
    {
        $browseNodeProducts = [
            $this->getBrowseNodeProductWithBrowseNodeName('Foo'),
            $this->getBrowseNodeProductWithBrowseNodeName('Bar'),
        ];
        $this->browseNodeProductsServiceMock
            ->method('getBrowseNodeProducts')
            ->willReturn($browseNodeProducts);

        $productEntity = new AmazonEntity\Product();

        $this->assertSame(
            $this->browseNodeNameDomainArray['default'],
            $this->domainService->getDomain($productEntity)
        );
    }

    protected function getBrowseNodeProductWithBrowseNodeName(
        string $browseNodeName
    ): AmazonEntity\BrowseNodeProduct {
        $browseNodeProduct = new AmazonEntity\BrowseNodeProduct();
        $browseNodeProduct->setBrowseNode(
            (new AmazonEntity\BrowseNode())->setName($browseNodeName)
        );
        return $browseNodeProduct;
    }
}
